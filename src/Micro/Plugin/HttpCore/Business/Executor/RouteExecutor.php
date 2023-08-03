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

namespace Micro\Plugin\HttpCore\Business\Executor;

use Micro\Framework\DependencyInjection\ContainerRegistryInterface;
use Micro\Plugin\HttpCore\Business\Matcher\UrlMatcherInterface;
use Micro\Plugin\HttpCore\Business\Response\Callback\ResponseCallbackFactoryInterface;
use Micro\Plugin\HttpCore\Business\Response\Transformer\ResponseTransformerFactoryInterface;
use Micro\Plugin\HttpCore\Exception\HttpException;
use Micro\Plugin\HttpCore\Exception\HttpInternalServerException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class RouteExecutor implements RouteExecutorInterface
{
    public function __construct(
        private UrlMatcherInterface $urlMatcher,
        private ContainerRegistryInterface $containerRegistry,
        private ResponseCallbackFactoryInterface $responseCallbackFactory,
        private ResponseTransformerFactoryInterface $responseTransformerFactory
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function execute(Request $request, bool $flush = true): Response
    {
        $route = $this->urlMatcher->match($request);
        $this->containerRegistry->register(Request::class, fn (): Request => $request);
        $callback = $this->responseCallbackFactory->create($route);

        try {
            $response = $callback();
            $response = $this->generateResponse($request, $response);
        } catch (HttpException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            $response = $this->generateResponse($request, $exception, false);
        }

        if ($flush) {
            $response->send();
        }

        return $response;
    }

    protected function generateResponse(Request $request, mixed $responseData, bool $tryIfThrowNoHttpException = true): Response
    {
        if ($responseData instanceof Response) {
            return $responseData;
        }

        $response = new Response();
        try {
            $transformed = $this->responseTransformerFactory
                ->create()
                ->transform(
                    $request,
                    $response,
                    $responseData
                );
        } catch (HttpException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            if ($tryIfThrowNoHttpException) {
                return $this->generateResponse($request, $exception, false);
            }

            throw new HttpInternalServerException('Internal Server Error.', $exception);
        }

        if (!$transformed) {
            throw new HttpInternalServerException('Internal Server Error.', $responseData instanceof \Throwable ? $responseData : null);
        }

        return $response;
    }
}
