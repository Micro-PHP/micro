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
use Monolog\Handler\HandlerInterface;

class HandlerProvider implements HandlerProviderInterface
{
    /**
     * @var array<string, HandlerInterface>
     */
    private array $handlerCollection;

    public function __construct(
        private readonly HandlerFactoryInterface $handlerFactory
    ) {
        $this->handlerCollection = [];
    }

    public function getHandler(LoggerProviderTypeConfigurationInterface $loggerProviderTypeConfiguration, string $handlerName): HandlerInterface
    {
        if (!\array_key_exists($handlerName, $this->handlerCollection)) {
            $this->handlerCollection[$handlerName] = $this->handlerFactory->create($loggerProviderTypeConfiguration, $handlerName);
        }

        return $this->handlerCollection[$handlerName];
    }
}
