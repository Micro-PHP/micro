<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Logger\Tests\Unit\Business\Provider;

use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\Logger\Business\Factory\LoggerFactoryInterface;
use Micro\Plugin\Logger\Business\Provider\LoggerProvider;
use Micro\Plugin\Logger\Configuration\LoggerPluginConfigurationInterface;
use Micro\Plugin\Logger\Configuration\LoggerProviderTypeConfigurationInterface;
use Micro\Plugin\Logger\Exception\LoggerAdapterAlreadyExistsException;
use Micro\Plugin\Logger\Exception\LoggerAdapterNameInvalidException;
use Micro\Plugin\Logger\Exception\LoggerAdapterNotRegisteredException;
use Micro\Plugin\Logger\Plugin\LoggerProviderPluginInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LoggerProviderTest extends TestCase
{
    private LoggerProvider $loggerProvider;

    private KernelInterface $kernel;

    private LoggerPluginConfigurationInterface $loggerPluginConfiguration;

    private LoggerFactoryInterface $loggerFactory;

    private LoggerProviderPluginInterface $loggerProviderPlugin;

    private LoggerInterface $logger;

    protected function setUp(): void
    {
        $this->kernel = $this->createMock(KernelInterface::class);
        $this->loggerPluginConfiguration = $this->createMock(LoggerPluginConfigurationInterface::class);
        $this->loggerFactory = $this->createMock(LoggerFactoryInterface::class);
        $this->loggerProviderPlugin = $this->createMock(LoggerProviderPluginInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->loggerProvider = new LoggerProvider($this->kernel, $this->loggerPluginConfiguration);
    }

    public function testGetLoggerWhenOnlyOneproviderRegistered(): void
    {
        $loggerProviderTypeConfig = $this->createMock(LoggerProviderTypeConfigurationInterface::class);

        $this->loggerPluginConfiguration
            ->method('getLoggerProviderTypeConfig')
            ->with('loggerName')
            ->willReturn($loggerProviderTypeConfig);

        $this->kernel
            ->expects($this->once())
            ->method('plugins')
            ->with(LoggerProviderPluginInterface::class)
            ->willReturn(new \ArrayObject([$this->loggerProviderPlugin]));

        $this->loggerFactory
            ->expects($this->once())
            ->method('create')
            ->with($loggerProviderTypeConfig)
            ->willReturn($this->logger);

        $this->loggerProviderPlugin
            ->expects($this->once())
            ->method('getLoggerFactory')
            ->willReturn($this->loggerFactory);

        $this->loggerProviderPlugin
            ->expects($this->once())
            ->method('getLoggerAdapterName')
            ->willReturn('test_adapter');

        $this->assertSame($this->logger, $this->loggerProvider->getLogger('loggerName'));
        // Cached
        $this->assertSame($this->logger, $this->loggerProvider->getLogger('loggerName'));
    }

    /**
     * @dataProvider dataProviderGetLoggerWhenManyOneProviderRegistered
     */
    public function testGetLoggerWhenManyOneProviderRegistered(bool $shouldAdaptedNotFoundException): void
    {
        $loggerProviderTypeConfig = $this->createMock(LoggerProviderTypeConfigurationInterface::class);
        $loggerProviderTypeConfig
            ->expects($this->once())
            ->method('getType')
            ->willReturn($shouldAdaptedNotFoundException ? 'not_registered_adapter' : 'test_adapter');

        if ($shouldAdaptedNotFoundException) {
            $this->expectException(LoggerAdapterNotRegisteredException::class);
        }

        $providerNotUsed = $this->createMock(LoggerProviderPluginInterface::class);
        $providerNotUsed
            ->expects($this->once())
            ->method('getLoggerAdapterName')
            ->willReturn('not_used_provider');

        $this->loggerPluginConfiguration
            ->method('getLoggerProviderTypeConfig')
            ->with('loggerName')
            ->willReturn($loggerProviderTypeConfig);

        $this->loggerPluginConfiguration
            ->method('getLoggerProviderTypeConfig')
            ->with('loggerName')
            ->willReturn($loggerProviderTypeConfig);

        $this->loggerProviderPlugin
            ->expects($this->once())
            ->method('getLoggerAdapterName')
            ->willReturn('test_adapter');

        $this->kernel
            ->expects($this->once())
            ->method('plugins')
            ->with(LoggerProviderPluginInterface::class)
            ->willReturn(new \ArrayObject([
                $providerNotUsed,
                $this->loggerProviderPlugin,
            ]));

        if (!$shouldAdaptedNotFoundException) {
            $this->loggerFactory
                ->expects($this->once())
                ->method('create')
                ->with($loggerProviderTypeConfig)
                ->willReturn($this->logger);

            $this->loggerProviderPlugin
                ->expects($this->once())
                ->method('getLoggerFactory')
                ->willReturn($this->loggerFactory);
        }

        $this->assertSame($this->logger, $this->loggerProvider->getLogger('loggerName'));
        // Cached
        $this->assertSame($this->logger, $this->loggerProvider->getLogger('loggerName'));
    }

    public function dataProviderGetLoggerWhenManyOneProviderRegistered()
    {
        return [
            [true],
            [false],
        ];
    }

    public function testGetLoggerNotRegisteredAdapterThrowsException(): void
    {
        $this->expectException(LoggerAdapterAlreadyExistsException::class);

        $this->loggerProviderPlugin
            ->method('getLoggerAdapterName')
            ->willReturn('duplicated_provider');

        $this->kernel
            ->expects($this->once())
            ->method('plugins')
            ->willReturn(new \ArrayObject([
                $this->loggerProviderPlugin,
                $this->loggerProviderPlugin,
            ]))
        ;

        $this->loggerProvider->getLogger('loggerName');
    }

    public function testAdapterNameInvalidThrowsException(): void
    {
        $this->expectException(LoggerAdapterNameInvalidException::class);

        $this->loggerProviderPlugin
            ->method('getLoggerAdapterName')
            ->willReturn(' ');

        $this->kernel
            ->expects($this->once())
            ->method('plugins')
            ->willReturn(new \ArrayObject([
                $this->loggerProviderPlugin,
            ]))
        ;

        $this->loggerProvider->getLogger('loggerName');
    }

    public function testAdapterAlreadyRegisteredThrowsException(): void
    {
        $this->expectException(LoggerAdapterNotRegisteredException::class);
        $this->kernel
            ->expects($this->once())
            ->method('plugins')
            ->willReturn(new \ArrayObject([]))
        ;

        $this->loggerProvider->getLogger('loggerName');
    }
}
