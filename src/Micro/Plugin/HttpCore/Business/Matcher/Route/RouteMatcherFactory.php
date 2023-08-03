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

namespace Micro\Plugin\HttpCore\Business\Matcher\Route;

use Micro\Plugin\HttpCore\Business\Matcher\Route\Matchers\MethodMatcher;
use Micro\Plugin\HttpCore\Business\Matcher\Route\Matchers\UriMatcher;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class RouteMatcherFactory implements RouteMatcherFactoryInterface
{
    public function create(): RouteMatcherInterface
    {
        return new RouteMatcher([
            new MethodMatcher(),
            new UriMatcher(),
        ]);
    }
}
