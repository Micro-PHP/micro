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

namespace Micro\Plugin\Filesystem;

use Micro\Framework\BootConfiguration\Configuration\Exception\InvalidConfigurationException;
use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\Filesystem\Configuration\Adapter\FilesystemAdapterConfigurationInterface;
use Micro\Plugin\Filesystem\Configuration\FilesystemPluginConfigurationInterface;

class FilesystemPluginConfiguration extends PluginConfiguration implements FilesystemPluginConfigurationInterface
{
    public const CFG_ADAPTER_TYPE = 'MICRO_FS_%s_TYPE';

    /**
     * {@inheritDoc}
     */
    public function createAdapterConfiguration(string $adapterName, string $adapterCfgClass): FilesystemAdapterConfigurationInterface
    {
        if (!class_exists($adapterCfgClass)) {
            throw new InvalidConfigurationException(sprintf('Adapter "%s" can not be configured. Configuration class "%s" not exists.', $adapterName, $adapterCfgClass));
        }

        return new $adapterCfgClass($this->configuration, $adapterName);
    }

    /**
     * {@inheritDoc}
     */
    public function getAdapterType(string $adapterName): string
    {
        return mb_strtolower(
            $this->configuration->get(
                sprintf(self::CFG_ADAPTER_TYPE, mb_strtoupper($adapterName)),
                null,
                false
            )
        );
    }

    /**
     * @param string $adapterName
     *
     * @throws \Exception
     *
     * @return FilesystemAdapterConfigurationInterface
     */
    public function getAdapterConfiguration(string $adapterName): FilesystemAdapterConfigurationInterface
    {
        $message = <<<EOF
            No configuration available for filesystem adapter `%s`.
            Please, implement your adapter or install exiting like as
                 * `micro/micro/plugin-filesystem-s3`
                 * `micro/micro/plugin-filesystem-local`
        EOF;

        throw new InvalidConfigurationException(sprintf($message, $adapterName));
    }
}
