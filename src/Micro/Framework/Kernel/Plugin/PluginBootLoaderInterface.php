<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\Kernel\Plugin;

/**
 * An interface that allows you to declare plugin loading behavior. Called when the plugin is initialized.
 *
 * Do not use this interface unless absolutely necessary.
 *
 * <a href="https://github.com/Micro-PHP/kernel-bootloader-configuration/blob/master/src/Boot/ConfigurationProviderBootLoader.php">
 *      An example of the implementation of the loader to create an object with the plugin configuration.
 * </a>
 *
 * @api
 */
interface PluginBootLoaderInterface
{
    /**
     * Immediately after creation, a pre-configuration plugin gets here.
     *
     * @api
     */
    public function boot(object $applicationPlugin): void;
}
