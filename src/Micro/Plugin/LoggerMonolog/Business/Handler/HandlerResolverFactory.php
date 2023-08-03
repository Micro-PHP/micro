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

readonly class HandlerResolverFactory implements HandlerResolverFactoryInterface
{
    public function __construct(
        private MonologPluginConfigurationInterface $pluginConfiguration,
        private HandlerProviderInterface $handlerProvider
    ) {
    }

    public function create(LoggerProviderTypeConfigurationInterface $loggerProviderTypeConfiguration): HandlerResolverInterface
    {
        return new HandlerResolver(
            $this->pluginConfiguration,
            $this->handlerProvider,
            $loggerProviderTypeConfiguration
        );
    }
}
