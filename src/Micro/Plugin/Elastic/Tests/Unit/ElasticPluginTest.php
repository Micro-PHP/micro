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

namespace Micro\Plugin\Elastic\Tests\Unit;

use Micro\Framework\KernelApp\AppKernel;
use Micro\Plugin\Elastic\ElasticPlugin;
use Micro\Plugin\Elastic\Facade\ElasticFacadeInterface;
use PHPUnit\Framework\TestCase;

class ElasticPluginTest extends TestCase
{
    public function testPlugin()
    {
        $kernel = new AppKernel([], [
            ElasticPlugin::class,
        ]);

        $kernel->run();
        $facade = $kernel->container()->get(ElasticFacadeInterface::class);

        $this->assertNotNull($facade);
    }
}
