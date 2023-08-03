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

use Micro\Framework\KernelApp\AppKernelInterface;
use Micro\Plugin\DTO\Business\FileLocator\FileLocatorFactory;
use Micro\Plugin\DTO\DTOPluginConfigurationInterface;
use PHPUnit\Framework\TestCase;

class FileLocatorFactoryTest extends TestCase
{
    public function testCreate()
    {
        $appKernel = $this->createMock(AppKernelInterface::class);
        $cfg = $this->createMock(DTOPluginConfigurationInterface::class);

        $factory = new FileLocatorFactory(
            $appKernel,
            $cfg,
        );

        $this->assertNotNull($factory->create());
    }
}
