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

namespace Micro\Plugin\DTO\Tests\Unit;

use Micro\Framework\KernelApp\AppKernel;
use Micro\Library\DTO\SerializerFacadeInterface;
use Micro\Library\DTO\ValidatorFacadeInterface;
use Micro\Plugin\DTO\DTOPlugin;
use Micro\Plugin\DTO\Facade\DTOFacadeInterface;
use PHPUnit\Framework\TestCase;

class DTOPluginTest extends TestCase
{
    public function testPlugin(): void
    {
        $kernel = new AppKernel([], [
            DTOPlugin::class,
        ]);

        $kernel->run();
        $this->assertInstanceOf(DTOFacadeInterface::class, $kernel->container()->get(DTOFacadeInterface::class));
        $this->assertInstanceOf(SerializerFacadeInterface::class, $kernel->container()->get(SerializerFacadeInterface::class));
        $this->assertInstanceOf(ValidatorFacadeInterface::class, $kernel->container()->get(ValidatorFacadeInterface::class));
    }
}
