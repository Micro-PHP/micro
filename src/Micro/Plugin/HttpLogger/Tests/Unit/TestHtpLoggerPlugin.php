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

namespace Micro\Plugin\HttpLogger\Tests\Unit;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Framework\BootPluginDependent\Plugin\PluginDependedInterface;
use Micro\Plugin\HttpCore\HttpCorePlugin;
use Micro\Plugin\Logger\LoggerPlugin;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class TestHtpLoggerPlugin implements DependencyProviderInterface, PluginDependedInterface
{
    use PluginConfigurationTrait;

    public function provideDependencies(Container $container): void
    {
    }

    public function getDependedPlugins(): iterable
    {
        return [
            HttpCorePlugin::class,
            LoggerPlugin::class,
        ];
    }
}
