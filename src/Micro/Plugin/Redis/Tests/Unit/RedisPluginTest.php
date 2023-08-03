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

namespace Micro\Plugin\Cache\Tests\Unit;

use Micro\Framework\KernelApp\AppKernel;
use Micro\Plugin\Redis\Facade\RedisFacadeInterface;
use Micro\Plugin\Redis\RedisPlugin;
use PHPUnit\Framework\TestCase;

class RedisPluginTest extends TestCase
{
    public function testPlugin()
    {
        $kernel = new AppKernel(
            [],
            [
                RedisPlugin::class,
            ]
        );

        $kernel->run();

        $this->expectException(\RedisException::class);
        $this->expectExceptionMessage('Connection refused');
        $facade = $kernel->container()->get(RedisFacadeInterface::class);
        $facadeDeprecated = $kernel->container()->get(\Micro\Plugin\Redis\RedisFacadeInterface::class);

        $this->assertEquals($facade, $facadeDeprecated);

        $kernel->container()->get(RedisFacadeInterface::class)->getClient();
    }
}
