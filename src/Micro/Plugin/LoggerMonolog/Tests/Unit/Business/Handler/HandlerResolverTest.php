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

namespace Micro\Plugin\LoggerMonolog\Tests\Unit\Business\Handler;

use Micro\Plugin\Logger\Configuration\LoggerProviderTypeConfigurationInterface;
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerProvider;
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerResolver;
use Micro\Plugin\LoggerMonolog\Configuration\Logger\LoggerConfigurationInterface;
use Micro\Plugin\LoggerMonolog\Configuration\Logger\MonologPluginConfigurationInterface;
use PHPUnit\Framework\TestCase;

class HandlerResolverTest extends TestCase
{
    public function testResolve()
    {
        $loggerProviderTypeConfiguration = $this->createMock(LoggerProviderTypeConfigurationInterface::class);
        $loggerProviderTypeConfiguration->expects($this->once())
            ->method('getLoggerName')
            ->willReturn('test');

        $testLoggerConfiguration = $this->createMock(LoggerConfigurationInterface::class);
        $testLoggerConfiguration
            ->expects($this->once())
            ->method('getHandlerList')
            ->willReturn(['test_handler']);

        $pluginConfiguration = $this->createMock(MonologPluginConfigurationInterface::class);
        $pluginConfiguration->expects($this->once())
            ->method('getLoggerConfiguration')
            ->willReturn($testLoggerConfiguration);

        $handlerProvider = $this->createMock(HandlerProvider::class);
        $handlerProvider->expects($this->once())
            ->method('getHandler')
            ->willReturn(new TestHandlerImpl());

        $resolver = new HandlerResolver($pluginConfiguration, $handlerProvider, $loggerProviderTypeConfiguration);
        $handlers = $resolver->resolve();

        $this->assertInstanceOf(\Traversable::class, $handlers);
        $this->assertCount(1, $handlers);
    }
}
