<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\BootDependency\Boot;

use Micro\Framework\Autowire\AutowireHelperFactory;
use Micro\Framework\Autowire\AutowireHelperInterface;
use Micro\Framework\Autowire\ContainerAutowire;
use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\Kernel\Plugin\PluginBootLoaderInterface;
use Psr\Container\ContainerInterface;

readonly class DependencyProviderBootLoader implements PluginBootLoaderInterface
{
    /**
     * @var Container
     */
    private ContainerInterface $container;

    /**
     * @param Container $container
     */
    public function __construct(ContainerInterface $container)
    {
        if (!($container instanceof ContainerAutowire)) {
            $container = new ContainerAutowire($container);
        }

        $this->container = $container;

        $this->container->register(
            AutowireHelperInterface::class,
            fn () => (new AutowireHelperFactory($this->container))->create()
        );
    }

    /**
     * @TODO: uncomment at 2.0 version
     *
     * {@inheritDoc}
     */
    public function boot(object $applicationPlugin): void
    {
        if (!($applicationPlugin instanceof DependencyProviderInterface)) {
            return;
        }

        $applicationPlugin->provideDependencies($this->container);
    }
}
