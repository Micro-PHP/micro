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

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\Cache\Business\Adapter\Concrete\ApcuFactory;
use Micro\Plugin\Cache\Configuration\Adapter\CachePoolConfiguration;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheException;
use Symfony\Component\Cache\Adapter\ApcuAdapter;

class ApcuFactoryTest extends TestCase
{
    public function testCreate()
    {
        if (!\extension_loaded('apc') || !\ini_get('apc.enabled')) {
            $this->expectException(CacheException::class);
        }

        $appCfg = new DefaultApplicationConfiguration([]);
        $cfg = new CachePoolConfiguration($appCfg, 'test');

        $factory = new ApcuFactory();
        $adapter = $factory->create($cfg);

        $this->assertInstanceOf(ApcuAdapter::class, $adapter);
    }
}
