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

namespace Micro\Plugin\HttpCore\Business\Route;

use Micro\Plugin\HttpCore\Business\Locator\RouteLocatorFactoryInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class RouteCollectionFactory implements RouteCollectionFactoryInterface
{
    private RouteCollectionInterface|null $routeCollection;

    public function __construct(
        private readonly RouteLocatorFactoryInterface $routeLocatorFactory
    ) {
        $this->routeCollection = null;
    }

    public function create(): RouteCollectionInterface
    {
        if ($this->routeCollection) {
            return $this->routeCollection;
        }

        $collection = new RouteCollection();

        $locator = $this->routeLocatorFactory->create();
        foreach ($locator->locate() as $route) {
            $collection->addRoute($route);
        }

        return $this->routeCollection = $collection;
    }
}
