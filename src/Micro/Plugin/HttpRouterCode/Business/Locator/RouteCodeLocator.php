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

namespace Micro\Plugin\HttpRouterCode\Business\Locator;

use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\HttpCore\Business\Locator\RouteLocatorInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Micro\Plugin\HttpRouterCode\Plugin\RouteProviderPluginInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class RouteCodeLocator implements RouteLocatorInterface
{
    public function __construct(
        private KernelInterface $kernel,
        private HttpFacadeInterface $httpFacade
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function locate(): iterable
    {
        $iterator = $this->kernel->plugins(RouteProviderPluginInterface::class);
        /** @var RouteProviderPluginInterface $plugin */
        foreach ($iterator as $plugin) {
            foreach ($plugin->provideRoutes($this->httpFacade) as $route) {
                yield $route;
            }
        }
    }
}
