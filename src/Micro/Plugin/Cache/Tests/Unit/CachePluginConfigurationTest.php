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
use Micro\Plugin\Cache\CachePlugin;
use Micro\Plugin\Cache\Facade\CacheFacadeInterface;
use Micro\Plugin\Doctrine\DoctrinePlugin;
use PHPUnit\Framework\TestCase;

class CachePluginConfigurationTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testGetPoolConfiguration(array $cfg)
    {
        $kernel = new AppKernel(
            $cfg,
            [
                CachePlugin::class,
                DoctrinePlugin::class,
            ],
        );

        $kernel->run();
        $facade = $kernel->container()->get(CacheFacadeInterface::class);
        $cache6 = $facade->getCachePsr6('test');
        $cache16 = $facade->getCachePsr16('test');
        $cacheSf = $facade->getCacheSymfony('test');

        $key6 = uniqid();
        $key16 = uniqid();
        $keySf = uniqid();
        $val = new \stdClass();
        $val->hello = 'World';

        $cached16 = $cache16->getItem($key16);
        $cached16->set($val);
        $cache16->save($cached16);

        $this->assertEquals($val, $cache16->getItem($key16)->get());
        $this->assertEquals($val, $cached16->get());
        $this->assertEquals($val, $cacheSf->get($keySf, fn () => $val));

        $cacheItem = $cache6->getItem($key6);
        $cacheItem->set($val);
        $cache6->save($cacheItem);
        $cacheItem = $cache6->getItem($key6);
        $cachedValue = $cacheItem->get();

        $this->assertInstanceOf(\stdClass::class, $cachedValue);
        $this->assertEquals('World', $cachedValue->hello);
    }

    public static function dataProvider(): array
    {
        return [
            [
                [
                    'MICRO_CACHE_TEST_TYPE' => 'filesystem',
                ],
            ],
            [
                [
                    'MICRO_CACHE_TEST_TYPE' => 'php_files',
                ],
            ],
            [
                [
                    'MICRO_CACHE_TEST_TYPE' => 'array',
                ],
            ],
            [
                [
                    'MICRO_CACHE_TEST_CONNECTION' => 'test',
                    'ORM_TEST_DRIVER' => 'pdo_sqlite',
                    'ORM_TEST_IN_MEMORY' => true,

                    'MICRO_CACHE_TEST_TYPE' => 'doctrine',
                ],
            ],
        ];
    }
}
