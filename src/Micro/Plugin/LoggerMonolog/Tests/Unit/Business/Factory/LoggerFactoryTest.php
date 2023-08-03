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

namespace Micro\Plugin\LoggerMonolog\Tests\Unit\Business\Factory;

use Micro\Plugin\Logger\Configuration\LoggerProviderTypeConfigurationInterface;
use Micro\Plugin\LoggerMonolog\Business\Factory\LoggerFactory;
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerResolverFactoryInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LoggerFactoryTest extends TestCase
{
    public function testCreate()
    {
        $handlerResolverFactory = $this->createMock(HandlerResolverFactoryInterface::class);
        $loggerProviderTypeConfiguration = $this->createMock(LoggerProviderTypeConfigurationInterface::class);
        $loggerProviderTypeConfiguration->expects($this->once())
            ->method('getLoggerName')
            ->willReturn('test');

        $factory = new LoggerFactory($handlerResolverFactory);
        $logger = $factory->create($loggerProviderTypeConfiguration);

        $this->assertInstanceOf(LoggerInterface::class, $logger);
        $this->assertEquals('test', $logger->getName());
    }
}
