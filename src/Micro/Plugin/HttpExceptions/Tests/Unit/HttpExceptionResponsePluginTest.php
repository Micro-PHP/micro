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

namespace Micro\Plugin\HttpExceptions\Tests\Unit;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Plugin\HttpExceptions\Decorator\ExceptionResponseBuilderDecorator;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Micro\Plugin\HttpCore\HttpCorePlugin;
use Micro\Plugin\HttpExceptions\HttpExceptionResponsePlugin;
use Micro\Plugin\HttpExceptions\HttpExceptionResponsePluginConfiguration;
use PHPUnit\Framework\TestCase;

/**
 * @author ChatGPT Jan 9 Version
 */
class HttpExceptionResponsePluginTest extends TestCase
{
    public function testProvideDependencies()
    {
        $containerMock = new Container();
        $containerMock->register(HttpFacadeInterface::class, fn () => $this->createMock(HttpFacadeInterface::class));

        $configMock = new HttpExceptionResponsePluginConfiguration(
            $this->createMock(ApplicationConfigurationInterface::class)
        );

        $plugin = new HttpExceptionResponsePlugin();
        $plugin->setConfiguration($configMock);
        $plugin->provideDependencies($containerMock);

        $this->assertInstanceOf(ExceptionResponseBuilderDecorator::class, $containerMock->get(HttpFacadeInterface::class));
    }

    public function testGetDependedPlugins()
    {
        $plugin = new HttpExceptionResponsePlugin();
        $dependedPlugins = $plugin->getDependedPlugins();

        $this->assertIsArray($dependedPlugins);
        $this->assertContains(HttpCorePlugin::class, $dependedPlugins);
    }
}
