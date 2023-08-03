<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\LoggerMonolog\Configuration\Logger;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Plugin\LoggerMonolog\Configuration\Handler\Type\HandlerStreamConfigurationInterface;

interface MonologPluginConfigurationInterface
{
    public const HANDLER_DEFAULT = 'default';
    public const HANDLER_DEFAULT_TYPE = HandlerStreamConfigurationInterface::TYPE;
    public const LOGGER_DEFAULT = 'default';

    public function getLoggerConfiguration(string $loggerConfiguration): LoggerConfigurationInterface;

    /**
     * @return iterable<string>
     */
    public function getHandlerList(): iterable;

    public function getHandlerDefault(): string;

    public function getHandlerType(string $handlerName): ?string;

    /**
     * @return iterable<string>
     */
    public function getLoggerList(): iterable;

    public function applicationConfiguration(): ApplicationConfigurationInterface;
}
