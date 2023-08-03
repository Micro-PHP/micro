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

namespace Micro\Plugin\HttpLogger\Business\Executor;

use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorInterface;
use Micro\Plugin\HttpLogger\Business\Logger\Formatter\LogFormatterInterface;
use Micro\Plugin\HttpCore\Exception\HttpException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class HttpExecutorLoggerAwareDecorator implements RouteExecutorInterface
{
    public function __construct(
        private RouteExecutorInterface $decorated,
        private LoggerInterface $loggerAccess,
        private LoggerInterface $loggerError,
        private LogFormatterInterface $logAccessFormatter,
        private LogFormatterInterface $logErrorFormatter
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function execute(Request $request, bool $flush = true): Response
    {
        $response = null;
        try {
            $response = $this->decorated->execute($request, false);
            if ($flush) {
                $response->send();
            }

            return $response;
        } catch (HttpException $exception) {
            if ($exception->getCode() >= 500) {
                $this->loggerError->critical(
                    $this->logErrorFormatter->format($request, $response, $exception),
                    [
                        'exception' => $exception,
                    ]
                );

                throw $exception;
            }

            $this->loggerError->info(
                $this->logErrorFormatter->format($request, $response, $exception),
                [
                    'exception' => $exception,
                ]
            );

            throw $exception;
        } catch (\Throwable $exception) {
            $this->loggerError->critical(
                $this->logErrorFormatter->format($request, $response, $exception),
                [
                    'exception' => $exception,
                ]
            );

            throw $exception;
        } finally {
            $this->loggerAccess->info(
                $this->logAccessFormatter->format($request, $response, null)
            );
        }
    }
}
