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

namespace Micro\Plugin\HttpCore\Business\Matcher;

use Micro\Plugin\HttpCore\Business\Matcher\Route\RouteMatcherInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteCollectionInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use Micro\Plugin\HttpCore\Exception\HttpNotFoundException;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class UrlMatcher implements UrlMatcherInterface
{
    public function __construct(
        private RouteMatcherInterface $routeMatcher,
        private RouteCollectionInterface $routeCollection,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function match(Request $request): RouteInterface
    {
        foreach ($this->routeCollection->iterateRoutes() as $route) {
            if (!$this->routeMatcher->match($route, $request)) {
                continue;
            }

            return $route;
        }

        throw new HttpNotFoundException();
    }
}
