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

use Micro\Plugin\HttpCore\Exception\RouteAlreadyDeclaredException;
use Micro\Plugin\HttpCore\Exception\RouteNotFoundException;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class RouteCollection implements RouteCollectionInterface
{
    /**
     * @var array<string, RouteInterface>
     */
    private array $routes;

    /**
     * @var string[]
     */
    private array $routesNamesStatic;

    /**
     * @var string[]
     */
    private array $routesNamesDynamic;

    /**
     * @param RouteInterface[] $routes
     */
    public function __construct(array $routes = [])
    {
        $this->routes = [];
        $this->routesNamesDynamic = [];
        $this->routesNamesStatic = [];

        $this->setRoutes($routes);
    }

    /**
     * {@inheritDoc}
     */
    public function setRoutes(iterable $routes): self
    {
        $this->routes = [];
        $this->routesNamesDynamic = [];
        $this->routesNamesStatic = [];

        foreach ($routes as $route) {
            $this->addRoute($route);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addRoute(RouteInterface $route): self
    {
        $routeName = $route->getName();
        $routeUri = $route->getUri();
        $routeKeyInCollection = $routeName ?? $routeUri;

        if ($routeName && \array_key_exists($routeName, $this->routes)) {
            throw new RouteAlreadyDeclaredException($routeName);
        }

        $this->routes[$routeKeyInCollection] = $route;

        if ($route->getPattern()) {
            $this->routesNamesDynamic[] = $routeKeyInCollection;

            return $this;
        }

        $this->routesNamesStatic[] = $routeKeyInCollection;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRouteByName(string $name): RouteInterface
    {
        if (!\array_key_exists($name, $this->routes)) {
            RouteNotFoundException::throwsRouteNotFoundByName($name);
        }

        return $this->routes[$name];
    }

    /**
     * {@inheritDoc}
     */
    public function getRoutes(): iterable
    {
        return array_values($this->routes);
    }

    /**
     * {@inheritDoc}
     */
    public function getRoutesNames(): array
    {
        return array_keys($this->routes);
    }

    /**
     * {@inheritDoc}
     */
    public function iterateRoutes(): iterable
    {
        foreach ($this->routesNamesStatic as $routeName) {
            yield $this->getRouteByName($routeName);
        }

        foreach ($this->routesNamesDynamic as $routeName) {
            yield $this->getRouteByName($routeName);
        }
    }
}
