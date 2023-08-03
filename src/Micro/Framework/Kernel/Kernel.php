<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\Kernel;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\Kernel\Plugin\PluginBootLoaderInterface;

class Kernel implements KernelInterface
{
    private bool $isStarted;

    /**
     * @var object[]
     */
    private array $plugins;

    /**
     * @var class-string[]
     */
    private array $pluginsLoaded;

    /**
     * @param class-string[]              $applicationPluginCollection
     * @param PluginBootLoaderInterface[] $pluginBootLoaderCollection
     */
    public function __construct(
        private readonly array $applicationPluginCollection,
        private array $pluginBootLoaderCollection,
        private readonly Container $container
    ) {
        $this->isStarted = false;

        $this->pluginsLoaded = [];
        $this->plugins = [];
    }

    public function addBootLoader(PluginBootLoaderInterface $bootLoader): self
    {
        if ($this->isStarted) {
            throw new \LogicException('Bootloaders must be installed before starting the kernel.');
        }

        $this->pluginBootLoaderCollection[] = $bootLoader;

        return $this;
    }

    public function setBootLoaders(iterable $bootLoaders): self
    {
        $this->pluginBootLoaderCollection = [];

        foreach ($bootLoaders as $loader) {
            $this->addBootLoader($loader);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        if ($this->isStarted) {
            return;
        }

        $this->loadPlugins();
        $this->isStarted = true;
    }

    /**
     * {@inheritDoc}
     */
    public function container(): Container
    {
        return $this->container;
    }

    /**
     * {@inheritDoc}
     */
    public function loadPlugin(string $applicationPluginClass): void
    {
        if (\in_array($applicationPluginClass, $this->pluginsLoaded, true)) {
            return;
        }

        $plugin = new $applicationPluginClass();

        foreach ($this->pluginBootLoaderCollection as $bootLoader) {
            $bootLoader->boot($plugin);
        }

        $this->plugins[] = $plugin;
        $this->pluginsLoaded[] = $applicationPluginClass;
    }

    /**
     * {@inheritDoc}
     */
    public function plugins(string $interfaceInherited = null): \Traversable
    {
        foreach ($this->plugins as $plugin) {
            if (!$interfaceInherited || ($plugin instanceof $interfaceInherited)) {
                yield $plugin;
            }
        }
    }

    protected function loadPlugins(): void
    {
        foreach ($this->applicationPluginCollection as $applicationPlugin) {
            $this->loadPlugin($applicationPlugin);
        }
    }
}
