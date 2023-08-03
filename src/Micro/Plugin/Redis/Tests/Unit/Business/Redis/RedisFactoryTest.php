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

namespace Micro\Plugin\Cache\Tests\Unit\Business\Redis;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\Redis\Business\Redis\RedisFactory;
use Micro\Plugin\Redis\Configuration\RedisClientConfiguration;
use PHPUnit\Framework\TestCase;

class RedisFactoryTest extends TestCase
{
    public function testCreate()
    {
        $this->expectException(\RedisException::class);

        $appCfg = new DefaultApplicationConfiguration([]);
        $cfg = new RedisClientConfiguration($appCfg, 'test');

        $factory = new RedisFactory();
        $factory->create($cfg);
    }
}
