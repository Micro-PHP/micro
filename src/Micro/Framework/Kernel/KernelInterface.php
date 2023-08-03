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

/**
 * The kernel is needed for plugin management. A plugin can be any class object.
 */
interface KernelInterface
{
    /**
     * Get service Dependency Injection Container.
     *
     * @api
     */
    public function container(): Container;

    /**
     * @throws \RuntimeException
     */
    public function addBootLoader(PluginBootLoaderInterface $bootLoader): self;

    /**
     * @param iterable<PluginBootLoaderInterface> $bootLoaders
     *
     * @throws \RuntimeException
     */
    public function setBootLoaders(iterable $bootLoaders): self;

    /**
     * Run application.
     *
     * @api
     */
    public function run(): void;

    /**
     * @param class-string $applicationPluginClass
     */
    public function loadPlugin(string $applicationPluginClass): void;

    /**
     * Iterate plugins with the specified type.
     *
     * @template T of object
     *
     * @psalm-param class-string<T>|null $interfaceInherited if empty, each connected plugin will be iterated

     *
     * @return \Traversable<T|object> Application plugins iterator
     *
     * @api
     */
    public function plugins(string $interfaceInherited = null): \Traversable;
}
