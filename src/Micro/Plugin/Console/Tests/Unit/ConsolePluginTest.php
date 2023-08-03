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

namespace Micro\Plugin\Console\Tests\Unit;

use Micro\Framework\Autowire\ContainerAutowire;
use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Plugin\Console\ConsolePlugin;
use Micro\Plugin\Console\Facade\ConsoleApplicationFacadeInterface;
use Micro\Plugin\Locator\Facade\LocatorFacadeInterface;
use PHPUnit\Framework\TestCase;

class ConsolePluginTest extends TestCase
{
    public function testPlugin()
    {
        $plugin = new ConsolePlugin();
        $this->assertInstanceOf(DependencyProviderInterface::class, $plugin);
        $container = new ContainerAutowire(new Container());
        $container->register(LocatorFacadeInterface::class, fn () => $this->createMock(LocatorFacadeInterface::class));
        $container->register(Container::class, fn () => $container);

        $plugin->provideDependencies($container);
        $this->assertInstanceOf(ConsoleApplicationFacadeInterface::class, $container->get(ConsoleApplicationFacadeInterface::class));
    }
}
