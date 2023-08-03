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

use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorFactoryInterface;
use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorInterface;
use Micro\Plugin\HttpLogger\Business\Logger\Formatter\LogFormatterFactoryInterface;
use Micro\Plugin\HttpLogger\HttpLoggerPluginConfigurationInterface;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class HttpExecutorLoggerAwareDecoratorFactory implements RouteExecutorFactoryInterface
{
    public function __construct(
        private RouteExecutorInterface $decorated,
        private LoggerFacadeInterface $loggerFacade,
        private LogFormatterFactoryInterface $logFormatterFactory,
        private HttpLoggerPluginConfigurationInterface $configuration
    ) {
    }

    public function create(): RouteExecutorInterface
    {
        return new HttpExecutorLoggerAwareDecorator(
            $this->decorated,
            $this->loggerFacade->getLogger($this->configuration->getAccessLoggerName()),
            $this->loggerFacade->getLogger($this->configuration->getErrorLoggerName()),
            $this->logFormatterFactory->create($this->configuration->getAccessLogFormat()),
            $this->logFormatterFactory->create($this->configuration->getErrorLogFormat())
        );
    }
}
