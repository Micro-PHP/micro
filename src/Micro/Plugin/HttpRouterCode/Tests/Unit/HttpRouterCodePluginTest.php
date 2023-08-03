<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpRouterCode\Tests\Unit;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Plugin\HttpCore\Business\Locator\RouteLocatorInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Micro\Plugin\HttpCore\HttpCorePlugin;
use Micro\Plugin\HttpCore\Plugin\HttpRouteLocatorPluginInterface;
use Micro\Plugin\HttpRouterCode\HttpRouterCodePlugin;
use PHPUnit\Framework\TestCase;

class HttpRouterCodePluginTest extends TestCase
{
    protected HttpRouterCodePlugin $plugin;

    protected Container $container;

    protected function setUp(): void
    {
        $this->container = $this->createMock(Container::class);
        $this->plugin = new HttpRouterCodePlugin();
        $this->plugin->provideDependencies($this->container);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(HttpRouteLocatorPluginInterface::class, $this->plugin);
    }

    public function testGetLocatorType()
    {
        $this->assertEquals('code', $this->plugin->getLocatorType());
    }

    public function testCreateLocator()
    {
        $this->container
            ->method('get')
            ->willReturn(
                $this->createMock(KernelInterface::class),
                $this->createMock(HttpFacadeInterface::class)
            );

        $this->assertInstanceOf(RouteLocatorInterface::class, $this->plugin->createLocator());
    }

    public function testProvideDependencies()
    {
        $this->assertInstanceOf(DependencyProviderInterface::class, $this->plugin);
    }

    public function testGetDependedPlugins()
    {
        $this->assertEquals(
            [HttpCorePlugin::class],
            $this->plugin->getDependedPlugins()
        );
    }
}
