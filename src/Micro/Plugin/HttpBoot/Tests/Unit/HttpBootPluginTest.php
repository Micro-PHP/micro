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

namespace Micro\Plugin\HttpBoot\Tests\Unit;

use Micro\Plugin\EventEmitter\EventEmitterPlugin;
use Micro\Plugin\HttpBoot\HttpBootPlugin;
use Micro\Plugin\HttpCore\HttpCorePlugin;
use PHPUnit\Framework\TestCase;

class HttpBootPluginTest extends TestCase
{
    public function testGetDependedPlugins()
    {
        $plugin = new HttpBootPlugin();

        $this->assertEquals([
            EventEmitterPlugin::class,
            HttpCorePlugin::class,
        ],
            $plugin->getDependedPlugins()
        );
    }
}
