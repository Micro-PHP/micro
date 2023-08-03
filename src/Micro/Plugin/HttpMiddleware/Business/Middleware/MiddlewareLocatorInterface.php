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

namespace Micro\Plugin\HttpMiddleware\Business\Middleware;

use Micro\Plugin\HttpMiddleware\Plugin\HttpMiddlewarePluginInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
interface MiddlewareLocatorInterface
{
    /**
     * @return \Traversable<HttpMiddlewarePluginInterface>
     */
    public function locate(Request $request): \Traversable;
}
