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

use Micro\Plugin\Redis\Business\Redis\RedisFactoryInterface;
use Micro\Plugin\Redis\Business\Redis\RedisManager;
use Micro\Plugin\Redis\RedisPluginConfigurationInterface;
use PHPUnit\Framework\TestCase;

class RedisManagerTest extends TestCase
{
    public function testGetClient()
    {
        $factory = $this->createMock(RedisFactoryInterface::class);
        $cfg = $this->createMock(RedisPluginConfigurationInterface::class);
        $cfg
            ->expects($this->once())
            ->method('getClientConfiguration')
            ->with('test')
        ;

        $redisManager = new RedisManager(
            $factory,
            $cfg,
        );

        $redisManager->getClient('test');
        $redisManager->getClient('test');
    }
}
