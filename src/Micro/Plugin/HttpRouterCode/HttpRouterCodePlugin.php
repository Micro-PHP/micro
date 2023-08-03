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

namespace Micro\Plugin\HttpRouterCode;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootPluginDependent\Plugin\PluginDependedInterface;
use Micro\Plugin\HttpCore\Business\Locator\RouteLocatorInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Micro\Plugin\HttpCore\HttpCorePlugin;
use Micro\Plugin\HttpCore\Plugin\HttpRouteLocatorPluginInterface;
use Micro\Plugin\HttpRouterCode\Business\Locator\RouteCodeLocator;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class HttpRouterCodePlugin implements HttpRouteLocatorPluginInterface, DependencyProviderInterface, PluginDependedInterface
{
    /**
     * @phpstan-ignore-next-line
     */
    private Container $container;

    public function provideDependencies(Container $container): void
    {
        // @phpstan-ignore-next-line
        $this->container = $container;
    }

    public function getLocatorType(): string
    {
        return 'code';
    }

    public function createLocator(): RouteLocatorInterface
    {
        $kernel = $this->container->get(KernelInterface::class);
        $httpFacade = $this->container->get(HttpFacadeInterface::class);
        // @phpstan-ignore-next-line
        return new RouteCodeLocator($kernel, $httpFacade);
    }

    /**
     * {@inheritDoc}
     */
    public function getDependedPlugins(): iterable
    {
        return [
            HttpCorePlugin::class,
        ];
    }
}
