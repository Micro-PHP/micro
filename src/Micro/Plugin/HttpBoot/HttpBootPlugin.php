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

namespace Micro\Plugin\HttpBoot;

use Micro\Framework\BootPluginDependent\Plugin\PluginDependedInterface;
use Micro\Plugin\EventEmitter\EventEmitterPlugin;
use Micro\Plugin\HttpCore\HttpCorePlugin;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class HttpBootPlugin implements PluginDependedInterface
{
    public function getDependedPlugins(): iterable
    {
        return [
            EventEmitterPlugin::class,
            HttpCorePlugin::class,
        ];
    }
}
