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

namespace Micro\Plugin\HttpCore\Business\Matcher\Route\Matchers;

use Micro\Plugin\HttpCore\Business\Matcher\Route\RouteMatcherInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class UriMatcher implements RouteMatcherInterface
{
    public function match(RouteInterface $route, Request $request): bool
    {
        $pathInfo = $request->getPathInfo();
        $pattern = $route->getPattern();
        if (!$pattern) {
            return $pathInfo === $route->getUri();
        }

        $matched = preg_match_all($pattern, $pathInfo, $matches);

        if (0 === $matched) {
            return false;
        }

        $i = 0;

        $parameters = $route->getParameters();
        if (!$parameters) {
            return true;
        }

        foreach ($parameters as $parameter) {
            if (!$parameter) {
                continue;
            }

            $request->request->set($parameter, $matches[++$i][0]);
        }

        return true;
    }
}
