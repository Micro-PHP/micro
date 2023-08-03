<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpLogger\Tests\Unit;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Plugin\HttpCore\HttpCorePlugin;
use Micro\Plugin\HttpLogger\HttpLoggerPlugin;
use Micro\Plugin\HttpLogger\HttpLoggerPluginConfiguration;
use Micro\Plugin\Logger\LoggerPlugin;
use PHPUnit\Framework\TestCase;

class HttpLoggerPluginTest extends TestCase
{
    private HttpLoggerPlugin $plugin;

    protected function setUp(): void
    {
        $this->plugin = new HttpLoggerPlugin();
        $this->plugin->setConfiguration(new HttpLoggerPluginConfiguration(
            new DefaultApplicationConfiguration([])
        ));
    }

    public function testGetDependedPlugins()
    {
        $this->assertInstanceOf(DependencyProviderInterface::class, $this->plugin);

        $this->assertEquals(
            [
                HttpCorePlugin::class,
                LoggerPlugin::class,
            ],
            $this->plugin->getDependedPlugins());
    }

    public function testProvideDependencies()
    {
        $this->assertInstanceOf(DependencyProviderInterface::class, $this->plugin);

        $container = $this->createMock(Container::class);
        $container
            ->expects($this->once())
            ->method('decorate')
        ;

        $this->plugin->provideDependencies($container);
    }
}
