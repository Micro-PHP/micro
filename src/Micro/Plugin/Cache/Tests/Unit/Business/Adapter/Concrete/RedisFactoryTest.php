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

namespace Micro\Plugin\Cache\Tests\Unit\Business\Adapter\Concrete;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\Cache\Business\Adapter\Concrete\RedisFactory;
use Micro\Plugin\Cache\Configuration\Adapter\CachePoolConfiguration;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheException;

class RedisFactoryTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testCreate(bool $isRedisInstalled)
    {
        $extLoaded = \extension_loaded('redis');
        if (!$extLoaded) {
            $this->expectException(CacheException::class);
            $this->expectExceptionMessage('Extension `redis` should be installed.');
        }

        $appCfg = new DefaultApplicationConfiguration([
            'MICRO_CACHE_TEST_CONNECTION' => 'test',
        ]);
        $cfg = new CachePoolConfiguration($appCfg, 'test');

        $container = new Container();
        // TODO: Implement after delete decorator `RedisInterface`
//        if($isRedisInstalled) {
//            $container->register(RedisFacadeInterface::class, function () {
//                $facade = $this->createMock(RedisFacadeInterface::class);
//                $facade->method('getClient')->willReturn(
//                    $this->createMock(\Redis::class);
//                );
//                return $facade;
//            });
//        } else {
        if ($extLoaded) {
            $this->expectException(CacheException::class);
            $this->expectExceptionMessage('Plugin `micro/plugin-redis` should be installed.');
        }
//        }

        $factory = new RedisFactory($container);
        $factory->create($cfg);
    }

    public static function dataProvider(): array
    {
        return [
            // [true],
            [false],
        ];
    }
}
