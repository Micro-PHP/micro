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

namespace Micro\Plugin\Filesystem\Tests\Unit;

use Micro\Framework\KernelApp\AppKernel;
use Micro\Plugin\Filesystem\Facade\FilesystemFacadeInterface;
use Micro\Plugin\Filesystem\FilesystemPlugin;
use PHPUnit\Framework\TestCase;

class FilesystemPluginTest extends TestCase
{
    public function testPlugin()
    {
        $kernel = new AppKernel(
            [],
            [FilesystemPlugin::class]
        );
        $kernel->run();
        /** @var FilesystemFacadeInterface $filesystem */
        $filesystem = $kernel->container()->get(FilesystemFacadeInterface::class);

        $this->assertInstanceOf(FilesystemFacadeInterface::class, $filesystem);
    }
}
