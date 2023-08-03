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

namespace Micro\Plugin\Logger\Configuration;

use Micro\Framework\BootConfiguration\Configuration\PluginRoutingKeyConfiguration;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class LoggerProviderTypeConfiguration extends PluginRoutingKeyConfiguration implements LoggerProviderTypeConfigurationInterface
{
    public const LOGGER_LOG_LEVEL = 'LOGGER_%s_LOG_LEVEL';
    public const CFG_LOGGER_PROVIDER_TYPE = 'LOGGER_%s_PROVIDER_TYPE';

    public function getLogLevel(): LogLevel
    {
        $levelString = $this->get(self::LOGGER_LOG_LEVEL);
        if (!$levelString) {
            return LogLevel::DEBUG;
        }

        return LogLevel::getLevelFromString($levelString);
    }

    public function getType(): string
    {
        return $this->get(self::CFG_LOGGER_PROVIDER_TYPE);
    }

    public function getLoggerName(): string
    {
        return $this->configRoutingKey;
    }
}
