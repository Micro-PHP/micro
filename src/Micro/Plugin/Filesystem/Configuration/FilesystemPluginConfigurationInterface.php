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

namespace Micro\Plugin\Filesystem\Configuration;

use Micro\Plugin\Filesystem\Configuration\Adapter\FilesystemAdapterConfigurationInterface;

interface FilesystemPluginConfigurationInterface
{
    public const ADAPTER_DEFAULT = 'default';

    /**
     * @param string                                                $adapterName
     * @param class-string<FilesystemAdapterConfigurationInterface> $adapterCfgClass
     *
     * @return FilesystemAdapterConfigurationInterface
     */
    public function createAdapterConfiguration(string $adapterName, string $adapterCfgClass): FilesystemAdapterConfigurationInterface;

    /**
     * @param string $adapterName
     *
     * @return string
     */
    public function getAdapterType(string $adapterName): string;

    /**
     * @param string $adapterName
     *
     * @return FilesystemAdapterConfigurationInterface
     */
    public function getAdapterConfiguration(string $adapterName): FilesystemAdapterConfigurationInterface;
}
