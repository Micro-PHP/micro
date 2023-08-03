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

use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\HttpMiddleware\Plugin\HttpMiddlewareOrderedPluginInterface;
use Micro\Plugin\HttpMiddleware\Plugin\HttpMiddlewarePluginInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class MiddlewareLocator implements MiddlewareLocatorInterface
{
    public function __construct(
        private KernelInterface $kernel
    ) {
    }

    public function locate(Request $request): \Traversable
    {
        /** @var \Generator<HttpMiddlewarePluginInterface> $it */
        $it = $this->kernel->plugins(HttpMiddlewarePluginInterface::class);
        $requestPath = $request->getPathInfo();

        /** @var array<int, HttpMiddlewarePluginInterface[]> $pc */
        $pc = [];
        $requestMethod = strtolower($request->getMethod());

        /** @var HttpMiddlewarePluginInterface $middleware */
        foreach ($it as $middleware) {
            $methods = array_map('strtolower', $middleware->getRequestMatchMethods());
            if (!\in_array($requestMethod, $methods)) {
                continue;
            }

            $middlewareMatch = $middleware->getRequestMatchPath();
            $pattern = '/'.preg_replace('/\//', '\/', $middlewareMatch).'/i';

            $isMatched = preg_match($pattern, $requestPath, $matches);
            if (!$isMatched) {
                continue;
            }

            $position = 0;
            if ($middleware instanceof HttpMiddlewareOrderedPluginInterface) {
                $position = $middleware->getMiddlewarePriority();
            }

            $pc[$position][] = $middleware;
        }

        foreach ($pc as $middlewaresColl) {
            foreach ($middlewaresColl as $middleware) {
                yield $middleware;
            }
        }
    }
}
