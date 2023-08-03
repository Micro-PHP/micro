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
class MethodMatcher implements RouteMatcherInterface
{
    public function match(RouteInterface $route, Request $request): bool
    {
        return \in_array(mb_strtoupper($request->getMethod()), $route->getMethods());
    }
}
