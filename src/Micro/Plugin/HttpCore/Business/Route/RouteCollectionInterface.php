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
interface RouteCollectionInterface
{
    /**
     * @param iterable<RouteInterface> $routes
     *
     * @return $this
     *
     * @throws RouteAlreadyDeclaredException
     */
    public function setRoutes(iterable $routes): self;

    /**
     * @return $this
     *
     * @throws RouteAlreadyDeclaredException
     */
    public function addRoute(RouteInterface $route): self;

    /**
     * @throws RouteNotFoundException
     */
    public function getRouteByName(string $name): RouteInterface;

    /**
     * @return RouteInterface[]
     */
    public function getRoutes(): iterable;

    /**
     * @return string[]
     */
    public function getRoutesNames(): array;

    /**
     * @return iterable<RouteInterface>
     */
    public function iterateRoutes(): iterable;
}
