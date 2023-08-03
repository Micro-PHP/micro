<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\LoggerMonolog\Business\Factory;

use Micro\Plugin\Logger\Business\Factory\LoggerFactoryInterface;
use Micro\Plugin\Logger\Configuration\LoggerProviderTypeConfigurationInterface;
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerResolverFactoryInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

readonly class LoggerFactory implements LoggerFactoryInterface
{
    public function __construct(
        private HandlerResolverFactoryInterface $handlerResolverFactory
    ) {
    }

    public function create(LoggerProviderTypeConfigurationInterface $loggerProviderTypeConfiguration): LoggerInterface
    {
        $logger = new Logger($loggerProviderTypeConfiguration->getLoggerName());
        $handlerCollectionGenerator = $this->handlerResolverFactory
            ->create($loggerProviderTypeConfiguration)
            ->resolve();

        $handlerCollection = iterator_to_array($handlerCollectionGenerator);

        $logger->setHandlers(array_values($handlerCollection));

        return $logger;
    }
}
