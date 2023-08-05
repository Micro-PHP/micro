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

namespace Micro\Framework\BootPluginDependent\Plugin;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
interface PluginDependedInterface
{
    /**
     * Returns a list of plugins that should be enabled in your application.
     *
     * @return iterable<class-string>
     */
    public function getDependedPlugins(): iterable;
}
