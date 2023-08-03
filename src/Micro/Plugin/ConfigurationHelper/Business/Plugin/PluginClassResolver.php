<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\ConfigurationHelper\Business\Plugin;

use Micro\Framework\BootConfiguration\Configuration\Exception\InvalidConfigurationException;
use Micro\Framework\Kernel\KernelInterface;

readonly class PluginClassResolver implements PluginClassResolverInterface
{
    public function __construct(
        private KernelInterface $kernel
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function resolve(string $pluginAlias): object
    {
        foreach ($this->kernel->plugins() as $plugin) {
            if ($this->getPluginName($plugin) === $pluginAlias) {
                return $plugin;
            }
        }

        throw new InvalidConfigurationException(sprintf('Plugin %s is not installed.', $pluginAlias));
    }

    protected function getPluginName(object $plugin): string
    {
        // TODO: Create interface for plugin naming
        if (method_exists($plugin, 'name')) {
            return $plugin->name();
        }

        $pluginName = \get_class($plugin);
        if (class_exists($pluginName)) {
            $exploded = explode('\\', $pluginName);

            return array_pop($exploded);
        }

        return $pluginName;
    }
}
