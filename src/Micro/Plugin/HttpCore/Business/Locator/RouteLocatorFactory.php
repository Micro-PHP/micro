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

namespace Micro\Plugin\HttpCore\Business\Locator;

use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\HttpCore\Configuration\HttpCorePluginConfigurationInterface;
use Micro\Plugin\HttpCore\Plugin\HttpRouteLocatorPluginInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class RouteLocatorFactory implements RouteLocatorFactoryInterface
{
    public function __construct(
        private KernelInterface $kernel,
        private HttpCorePluginConfigurationInterface $configuration
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function create(): RouteLocatorInterface
    {
        $providerType = mb_strtolower($this->configuration->getRouteLocatorType());

        /** @var HttpRouteLocatorPluginInterface $provider */
        foreach ($this->kernel->plugins(HttpRouteLocatorPluginInterface::class) as $provider) {
            if ($providerType !== mb_strtolower($provider->getLocatorType())) {
                continue;
            }

            return $provider->createLocator();
        }

        throw new \RuntimeException(sprintf('Route locator "%s" does not registered.', $providerType));
    }
}
