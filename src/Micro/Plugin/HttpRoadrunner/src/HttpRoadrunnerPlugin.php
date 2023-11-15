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

namespace Micro\Plugin\HttpRoadrunner;

use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootPluginDependent\Plugin\PluginDependedInterface;
use Micro\Framework\DependencyInjection\Container;
use Micro\Plugin\EventEmitter\EventEmitterPlugin;
use Micro\Plugin\HttpCore\HttpCorePlugin;
use Micro\Plugin\HttpRoadrunner\Facade\HttpRoadrunnerFacade;
use Micro\Plugin\HttpRoadrunner\Facade\HttpRoadrunnerFacadeInterface;

/**
 * @method HttpRoadrunnerPluginConfigurationInterface configuration()
 */
final class HttpRoadrunnerPlugin implements DependencyProviderInterface, PluginDependedInterface, ConfigurableInterface
{
    use PluginConfigurationTrait;

    public function provideDependencies(Container $container): void
    {
        $container->register(HttpRoadrunnerFacadeInterface::class, function () {
            return new HttpRoadrunnerFacade($this->configuration());
        });
    }

    public function getDependedPlugins(): iterable
    {
        return [
            EventEmitterPlugin::class,
            HttpCorePlugin::class,
        ];
    }
}
