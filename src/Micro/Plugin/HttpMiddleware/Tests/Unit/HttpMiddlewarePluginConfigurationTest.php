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

namespace Micro\Plugin\HttpMiddleware\Tests\Unit;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\HttpMiddleware\HttpMiddlewarePluginConfiguration;
use PHPUnit\Framework\TestCase;

class HttpMiddlewarePluginConfigurationTest extends TestCase
{
    public function testGetDecorationPriority()
    {
        $appCfg = new DefaultApplicationConfiguration([
            'HTTP_MIDDLEWARE_DECORATION_PRIORITY' => 1,
        ]);

        $pluginCfg = new HttpMiddlewarePluginConfiguration($appCfg);
        $this->assertEquals(1, $pluginCfg->getDecorationPriority());

        $pluginCfg = new HttpMiddlewarePluginConfiguration(new DefaultApplicationConfiguration([]));
        $this->assertEquals(150, $pluginCfg->getDecorationPriority());
    }
}
