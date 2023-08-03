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

namespace Micro\Plugin\HttpCore\Business\Generator;

use Micro\Plugin\HttpCore\Business\Route\RouteCollectionInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class UrlGenerator implements UrlGeneratorInterface
{
    public function __construct(private RouteCollectionInterface $routeCollection)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function generateUrlByRouteName(string $routeName, array|null $parameters = []): string
    {
        $route = $this->routeCollection->getRouteByName($routeName);
        $uri = $route->getUri();
        $routeParameters = $route->getParameters() ?? [];
        $parameters = $parameters ?? [];
        $parametersKeys = array_keys($parameters);

        sort($routeParameters);
        sort($parametersKeys);

        if ($routeParameters !== $parametersKeys) {
            throw new \RuntimeException('Route parameters mismatch. Parameters available: '.json_encode($routeParameters));
        }

        foreach ($parameters as $key => $value) {
            $uri = str_replace(sprintf('{%s}', $key), $value, $uri);
        }

        return $uri;
    }
}
