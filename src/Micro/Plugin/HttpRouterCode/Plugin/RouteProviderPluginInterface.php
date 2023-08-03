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

namespace Micro\Plugin\HttpRouterCode\Plugin;


use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
interface RouteProviderPluginInterface
{
    /**
     * @return iterable<RouteInterface>
     */
    public function provideRoutes(HttpFacadeInterface $httpFacade): iterable;
}
