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

namespace Micro\Plugin\Filesystem\Tests\Unit\Configuration\Adapter;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Plugin\Filesystem\Configuration\Adapter\AbstractFilesystemAdapterConfiguration;
use Micro\Plugin\Filesystem\Configuration\Adapter\FilesystemAdapterConfigurationInterface;
use PHPUnit\Framework\TestCase;

class AbstractFilesystemAdapterConfigurationTest extends TestCase
{
    public function testAbstraction()
    {
        $pubPath = '/path/to/public';
        $appCfg = $this->createMock(ApplicationConfigurationInterface::class);
        $appCfg
            ->expects($this->once())
            ->method('get')
            ->with('MICRO_FS_TEST_PUBLIC_URL')
            ->willReturn($pubPath);

        $cfg = new AbstractFilesystemAdapterConfigurationTestPlugin($appCfg, 'test');

        $this->assertInstanceOf(FilesystemAdapterConfigurationInterface::class, $cfg);
        $this->assertEquals($pubPath, $cfg->getPublicUrl());
    }
}

class AbstractFilesystemAdapterConfigurationTestPlugin extends AbstractFilesystemAdapterConfiguration
{
}
