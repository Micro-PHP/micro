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

namespace Micro\Plugin\HttpMiddleware\Business\Executor;

use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorInterface;
use Micro\Plugin\HttpMiddleware\Business\Middleware\MiddlewareLocatorInterface;
use Micro\Plugin\HttpMiddleware\Plugin\HttpMiddlewarePluginInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class RouteMiddlewareExecutor implements RouteExecutorInterface
{
    public function __construct(
        private RouteExecutorInterface $decorated,
        private MiddlewareLocatorInterface $middlewareLocator
    ) {
    }

    public function execute(Request $request, bool $flush = true): Response
    {
        /** @var HttpMiddlewarePluginInterface $middleware */
        foreach ($this->middlewareLocator->locate($request) as $middleware) {
            $middleware->processMiddleware($request);
        }

        return $this->decorated->execute($request, $flush);
    }
}
