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

namespace Micro\Plugin\Cache\Tests\Unit\Configuration\Adapter;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\Cache\Configuration\Adapter\CachePoolConfiguration;
use PHPUnit\Framework\TestCase;

class CachePoolConfigurationTest extends TestCase
{
    public function testGetVersion()
    {
        $appCfg = new DefaultApplicationConfiguration([
            'MICRO_CACHE_TEST_VERSION' => 'test_version',
        ]);
        $cfg = new CachePoolConfiguration(
            $appCfg,
            'test'
        );

        $this->assertEquals('test_version', $cfg->getVersion());
    }
}
