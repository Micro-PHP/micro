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

namespace Micro\Plugin\HttpExceptions\Business\Executor;

use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorInterface;
use Micro\Plugin\HttpCore\Exception\HttpException;
use Micro\Plugin\HttpCore\Exception\HttpInternalServerException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class HttpExceptionExecutorDecorator implements RouteExecutorInterface
{
    public function __construct(
        private RouteExecutorInterface $decorated
    ) {
    }

    public function execute(Request $request, bool $flush = true): Response
    {
        try {
            $response = $this->decorated->execute($request, false);
            if ($flush) {
                $response->send();
            }

            return $response;
        } catch (\Throwable $throwable) {
            if (!($throwable instanceof HttpException)) {
                $throwable = new HttpInternalServerException('Internal Server Error.', $throwable);
            }

            if (!$flush) {
                throw $throwable;
            }

            $response = new Response(
                $throwable->getMessage(),
                $throwable->getCode(),
            );

            $response->send();

            return $response;
        }
    }
}
