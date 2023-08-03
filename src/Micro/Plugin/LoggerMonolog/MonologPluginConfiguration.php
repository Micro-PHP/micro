<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\LoggerMonolog;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Plugin\Logger\LoggerPluginConfiguration;
use Micro\Plugin\LoggerMonolog\Configuration\Logger\LoggerConfiguration;
use Micro\Plugin\LoggerMonolog\Configuration\Logger\LoggerConfigurationInterface;
use Micro\Plugin\LoggerMonolog\Configuration\Logger\MonologPluginConfigurationInterface;

class MonologPluginConfiguration extends LoggerPluginConfiguration implements MonologPluginConfigurationInterface
{
    public const CFG_HANDLER_LIST = 'LOGGER_HANDLER_LIST';

    public const CFG_LOGGER_LIST = 'LOGGER_LIST';

    protected const CFG_HANDLER_TYPE = 'LOGGER_%s_TYPE';

    public function getHandlerType(string $handlerName): ?string
    {
        return $this->configuration->get(sprintf(self::CFG_HANDLER_TYPE, mb_strtoupper($handlerName)), self::HANDLER_DEFAULT_TYPE);
    }

    /**
     * @return iterable<string>
     */
    public function getLoggerList(): iterable
    {
        $loggerListSource = $this->configuration->get(self::CFG_LOGGER_LIST, self::LOGGER_DEFAULT);

        return $this->explodeStringToArray($loggerListSource);
    }

    public function getLoggerConfiguration(string $loggerConfiguration): LoggerConfigurationInterface
    {
        return new LoggerConfiguration($this->configuration, $loggerConfiguration);
    }

    /**
     * {@inheritDoc}
     */
    public function getHandlerList(): iterable
    {
        $handlerListSource = $this->configuration->get(self::CFG_HANDLER_LIST, $this->getHandlerDefault());

        return $this->explodeStringToArray($handlerListSource);
    }

    public function getHandlerDefault(): string
    {
        return self::HANDLER_DEFAULT;
    }

    public function applicationConfiguration(): ApplicationConfigurationInterface
    {
        return $this->configuration;
    }
}
