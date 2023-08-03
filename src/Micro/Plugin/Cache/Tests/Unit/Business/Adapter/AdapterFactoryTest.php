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

namespace Micro\Plugin\Cache\Tests\Unit\Business\Adapter;

use Micro\Plugin\Cache\Business\Adapter\AdapterFactory;
use Micro\Plugin\Cache\Business\Adapter\ConcreteAdapterFactoryInterface;
use Micro\Plugin\Cache\Configuration\Adapter\CachePoolConfigurationInterface;
use Micro\Plugin\Cache\Configuration\CachePluginConfigurationInterface;
use PHPUnit\Framework\TestCase;

class AdapterFactoryTest extends TestCase
{
    public function testCreateUnsupportedAdapter()
    {
        $cacheAdapterName = 'test';
        $cfgPool = $this->createMock(CachePoolConfigurationInterface::class);
        $cfgPool
            ->expects($this->once())
            ->method('getAdapterType')
            ->willReturn('unsupported_type');

        $cfg = $this->createMock(CachePluginConfigurationInterface::class);
        $cfg
            ->expects($this->once())
            ->method('getPoolConfiguration')
            ->with($cacheAdapterName)
            ->willReturn($cfgPool);

        $concreteFactory = $this->createMock(ConcreteAdapterFactoryInterface::class);
        $concreteFactory->expects($this->once())->method('type')->willReturn('file');

        $adapterFactory = new AdapterFactory(
            $cfg,
            new \ArrayObject([
                $concreteFactory,
            ])
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Can not initialize cache pool `test`. Adapter type `unsupported_type` is not supported. Available types: file');

        $adapterFactory->create($cacheAdapterName);
    }
}
