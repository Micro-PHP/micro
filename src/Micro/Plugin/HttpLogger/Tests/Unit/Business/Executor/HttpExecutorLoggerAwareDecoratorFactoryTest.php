<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpLogger\Tests\Unit\Business\Executor;

use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Micro\Plugin\HttpLogger\Business\Executor\HttpExecutorLoggerAwareDecoratorFactory;
use Micro\Plugin\HttpLogger\Business\Logger\Formatter\LogFormatterFactoryInterface;
use Micro\Plugin\HttpLogger\HttpLoggerPluginConfigurationInterface;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;
use PHPUnit\Framework\TestCase;

class HttpExecutorLoggerAwareDecoratorFactoryTest extends TestCase
{
    public function testCreate()
    {
        $factory = new HttpExecutorLoggerAwareDecoratorFactory(
            $this->createMock(HttpFacadeInterface::class),
            $this->createMock(LoggerFacadeInterface::class),
            $this->createMock(LogFormatterFactoryInterface::class),
            $this->createMock(HttpLoggerPluginConfigurationInterface::class),
        );

        $this->assertInstanceOf(RouteExecutorInterface::class, $factory->create());
    }
}
