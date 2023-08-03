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

use Micro\Framework\DependencyInjection\Container;
use Micro\Plugin\Logger\Configuration\LoggerProviderTypeConfigurationInterface;
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerFactory;
use Micro\Plugin\LoggerMonolog\Configuration\Handler\HandlerConfigurationFactoryInterface;
use Micro\Plugin\LoggerMonolog\Configuration\Handler\HandlerConfigurationInterface;
use PHPUnit\Framework\TestCase;

class HandlerFactoryTest extends TestCase
{
    public function testCreate()
    {
        $handlerConfig = $this->createMock(HandlerConfigurationInterface::class);
        $handlerConfig
            ->expects($this->once())
            ->method('getHandlerClassName')
            ->willReturn(TestHandlerImpl::class);

        $container = $this->createMock(Container::class);
        $handlerConfigurationFactory = $this->createMock(HandlerConfigurationFactoryInterface::class);
        $handlerConfigurationFactory->expects($this->once())
            ->method('create')
            ->willReturn($handlerConfig);

        $handlerFactory = new HandlerFactory($container, $handlerConfigurationFactory);
        $handler = $handlerFactory->create(
            $this->createMock(LoggerProviderTypeConfigurationInterface::class),
            'test');

        $this->assertInstanceOf(TestHandlerImpl::class, $handler);
    }
}
