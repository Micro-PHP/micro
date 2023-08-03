<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Logger;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\Logger\Configuration\LoggerPluginConfigurationInterface;
use Micro\Plugin\Logger\Configuration\LoggerProviderTypeConfiguration;
use Micro\Plugin\Logger\Configuration\LoggerProviderTypeConfigurationInterface;

class LoggerPluginConfiguration extends PluginConfiguration implements LoggerPluginConfigurationInterface
{
    public const LOGGER_NAME_DEFAULT = 'default';

    public function getLoggerDefaultName(): string
    {
        return self::LOGGER_NAME_DEFAULT;
    }

    public function getLoggerProviderTypeConfig(string $loggerName): LoggerProviderTypeConfigurationInterface
    {
        return new LoggerProviderTypeConfiguration($this->configuration, $loggerName);
    }
}
