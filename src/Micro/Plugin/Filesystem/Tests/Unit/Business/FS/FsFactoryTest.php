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

namespace Micro\Plugin\Filesystem\Tests\Unit\Business\FS;

use League\Flysystem\FilesystemAdapter;
use League\Flysystem\FilesystemOperator;
use Micro\Plugin\Filesystem\Business\Adapter\AdapterFactoryInterface;
use Micro\Plugin\Filesystem\Business\FS\FsFactory;
use Micro\Plugin\Filesystem\Configuration\Adapter\FilesystemAdapterConfigurationInterface;
use Micro\Plugin\Filesystem\Configuration\FilesystemPluginConfigurationInterface;
use PHPUnit\Framework\TestCase;

class FsFactoryTest extends TestCase
{
    public function testCreateExitingOperator()
    {
        $adapterCfg = $this->createMock(FilesystemAdapterConfigurationInterface::class);
        $adapterCfg
            ->expects($this->once())
            ->method('getPublicUrl')
            ->willReturn('http://test.com');

        $cfg = $this->createMock(FilesystemPluginConfigurationInterface::class);
        $cfg
            ->expects($this->once())
            ->method('getAdapterConfiguration')
            ->with('test')
            ->willReturn($adapterCfg);

        $adapterFactory = $this->createMock(AdapterFactoryInterface::class);
        $adapterFactory
            ->expects($this->once())
            ->method('create')
            ->with($adapterCfg)
            ->willReturn($this->createMock(FilesystemAdapter::class));

        $fsFactory = new FsFactory($cfg, $adapterFactory);

        $adapter = $fsFactory->create('test');
        $this->assertInstanceOf(FilesystemOperator::class, $adapter);
    }
}
