<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\LoggerMonolog\Business\Handler;

use Micro\Plugin\Logger\Configuration\LoggerProviderTypeConfigurationInterface;
use Micro\Plugin\LoggerMonolog\Configuration\Logger\MonologPluginConfigurationInterface;

readonly class HandlerResolver implements HandlerResolverInterface
{
    public function __construct(
        private MonologPluginConfigurationInterface $pluginConfiguration,
        private HandlerProviderInterface $handlerProvider,
        private LoggerProviderTypeConfigurationInterface $loggerProviderTypeConfiguration
    ) {
    }

    public function resolve(): \Traversable
    {
        $loggerConfiguration = $this->pluginConfiguration
            ->getLoggerConfiguration($this->loggerProviderTypeConfiguration->getLoggerName());

        foreach ($loggerConfiguration->getHandlerList() as $handlerName) {
            yield $this->handlerProvider->getHandler($this->loggerProviderTypeConfiguration, $handlerName);
        }
    }
}
