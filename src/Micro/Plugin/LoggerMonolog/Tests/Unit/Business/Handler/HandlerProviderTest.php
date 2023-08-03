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
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerFactoryInterface;
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerProvider;
use Monolog\Handler\HandlerInterface;
use PHPUnit\Framework\TestCase;

class HandlerProviderTest extends TestCase
{
    public function testGetHandler()
    {
        $loggerProviderTypeCfg = $this->createMock(LoggerProviderTypeConfigurationInterface::class);
        $handlerFactory = $this->createMock(HandlerFactoryInterface::class);
        $handlerFactory->expects($this->once())
            ->method('create')
            ->willReturn(new TestHandlerImpl());

        $provider = new HandlerProvider($handlerFactory);
        $handler = $provider->getHandler(
            $loggerProviderTypeCfg,
            'test');

        $this->assertSame($handler, $provider->getHandler($loggerProviderTypeCfg, 'test'));
        $this->assertInstanceOf(HandlerInterface::class, $handler);
    }
}
