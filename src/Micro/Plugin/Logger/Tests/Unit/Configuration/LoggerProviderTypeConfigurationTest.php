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

namespace Micro\Plugin\Logger\Tests\Unit\Configuration;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Plugin\Logger\Configuration\LoggerProviderTypeConfiguration;
use Micro\Plugin\Logger\Configuration\LoggerProviderTypeConfigurationInterface;
use Micro\Plugin\Logger\Configuration\LogLevel;
use PHPUnit\Framework\TestCase;

class LoggerProviderTypeConfigurationTest extends TestCase
{
    private ApplicationConfigurationInterface $applicationConfiguration;

    private LoggerProviderTypeConfigurationInterface $loggerProviderTypeConfiguration;

    protected function setUp(): void
    {
        $this->applicationConfiguration = $this->createMock(ApplicationConfigurationInterface::class);

        $this->loggerProviderTypeConfiguration = new LoggerProviderTypeConfiguration(
            $this->applicationConfiguration,
            'default'
        );
    }

    public function testDefaultLogLevel()
    {
        $this->applicationConfiguration
            ->expects($this->once())
            ->method('get')
            ->with('LOGGER_DEFAULT_LOG_LEVEL')
            ->willReturn(null);

        $this->assertEquals(LogLevel::DEBUG, $this->loggerProviderTypeConfiguration->getLogLevel());
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGetLogLevel(string|null $loggerLevel)
    {
        if ('invalid' === $loggerLevel) {
            $this->expectException(\RuntimeException::class);
        } else {
            $this->applicationConfiguration
                ->expects($this->once())
                ->method('get')
                ->with('LOGGER_DEFAULT_LOG_LEVEL')
                ->willReturn($loggerLevel ?: 'debug');
        }

        if (null !== $loggerLevel && 'default' !== $loggerLevel) {
            $this->assertEquals(LogLevel::getLevelFromString($loggerLevel), $this->loggerProviderTypeConfiguration->getLogLevel());

            return;
        }

        $this->assertEquals(LogLevel::DEBUG, $this->loggerProviderTypeConfiguration->getLogLevel());
    }

    public function dataProvider()
    {
        return [
            ['critical'],
            ['invalid'],
            [null],
        ];
    }

    public function testGetType()
    {
        $this->applicationConfiguration
            ->expects($this->once())
            ->method('get')
            ->with('LOGGER_DEFAULT_PROVIDER_TYPE')
            ->willReturn('default_type');

        $this->assertEquals('default_type', $this->loggerProviderTypeConfiguration->getType());
    }

    public function testGetLoggerName()
    {
        $this->assertEquals('default', $this->loggerProviderTypeConfiguration->getLoggerName());
    }
}
