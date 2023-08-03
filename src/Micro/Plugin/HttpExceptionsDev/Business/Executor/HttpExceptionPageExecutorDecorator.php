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

namespace Micro\Plugin\HttpExceptionsDev\Business\Executor;

use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorInterface;
use Micro\Plugin\HttpExceptionsDev\Business\Exception\Renderer\RendererFactoryInterface;
use Micro\Plugin\HttpExceptionsDev\Configuration\HttpExceptionResponseDevPluginConfigurationInterface;
use Micro\Plugin\HttpCore\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class HttpExceptionPageExecutorDecorator implements RouteExecutorInterface
{
    public function __construct(
        private RouteExecutorInterface $decorated,
        private RendererFactoryInterface $rendererFactory,
        private HttpExceptionResponseDevPluginConfigurationInterface $pluginConfiguration
    ) {
    }

    public function execute(Request $request, bool $flush = true): Response
    {
        if (!$this->pluginConfiguration->isDevMode()) {
            return $this->decorated->execute($request, $flush);
        }

        try {
            $response = $this->decorated->execute($request, false);
            if ($flush) {
                $response->send();
            }

            return $response;
        } catch (\Throwable $throwable) {
            if (!$flush) {
                throw $throwable;
            }

            $content = $this->rendererFactory
                ->create($request)
                ->render($throwable);

            $statusCode = 500;
            if ($throwable instanceof HttpException) {
                $statusCode = $throwable->getCode();
            }

            $contentType = $request->get('_format', 'text/html');
            $contentType = match ($contentType) {
                'json' => 'application/json',
                default => 'text/html',
            };

            $response = new Response($content, $statusCode, [
                'content-type' => $contentType,
            ]);

            $response->send();

            throw $throwable;
        }
    }
}
