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
use Psr\Container\ContainerInterface;

class KernelBuilder
{
    /**
     * @var class-string[]
     */
    private array $pluginCollection;

    /**
     * @var PluginBootLoaderInterface[]
     */
    private array $bootLoaderPluginCollection;

    private ?Container $container;

    public function __construct()
    {
        $this->pluginCollection = [];
        $this->bootLoaderPluginCollection = [];
        $this->container = null;
    }

    /**
     * @param class-string[] $applicationPluginCollection
     *
     * @return $this
     */
    public function setApplicationPlugins(array $applicationPluginCollection): self
    {
        $this->pluginCollection = $applicationPluginCollection;

        return $this;
    }

    /**
     * @return $this
     */
    public function addBootLoader(PluginBootLoaderInterface $bootLoader): self
    {
        $this->bootLoaderPluginCollection[] = $bootLoader;

        return $this;
    }

    /**
     * @param PluginBootLoaderInterface[] $bootLoaderCollection
     *
     * @return $this
     */
    public function addBootLoaders(iterable $bootLoaderCollection): self
    {
        foreach ($bootLoaderCollection as $bootLoader) {
            $this->addBootLoader($bootLoader);
        }

        return $this;
    }

    /**
     * @param Container $container
     *
     * @return $this
     */
    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;

        return $this;
    }

    protected function container(): Container
    {
        return $this->container ?? new Container();
    }

    /**
     * @return Kernel
     */
    public function build(): KernelInterface
    {
        return new Kernel(
            $this->pluginCollection,
            $this->bootLoaderPluginCollection,
            $this->container(),
        );
    }
}
