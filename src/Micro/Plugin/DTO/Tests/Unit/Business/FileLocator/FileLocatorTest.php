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

namespace Micro\Plugin\DTO\Tests\Unit\Business\FileLocator;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Framework\KernelApp\AppKernelInterface;
use Micro\Plugin\DTO\Business\FileLocator\FileLocator;
use Micro\Plugin\DTO\DTOPluginConfiguration;
use Micro\Plugin\DTO\Tests\Unit\TestPlugin;
use PHPUnit\Framework\TestCase;

class FileLocatorTest extends TestCase
{
    public function testLookup()
    {
        $appKernel = $this->createMock(AppKernelInterface::class);
        $appKernel->method('plugins')->willReturn(new \ArrayObject([
            new TestPlugin(),
        ]));

        $appCfg = new DefaultApplicationConfiguration([
            'DTO_CLASS_SOURCE_PATH' => __DIR__,
        ]);
        $cfg = new DTOPluginConfiguration($appCfg);

        $fileLocator = new FileLocator(
            $cfg,
            $appKernel,
        );

        $this->assertIsArray($fileLocator->lookup());
    }
}
