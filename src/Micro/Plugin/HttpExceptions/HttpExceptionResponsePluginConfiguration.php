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

namespace Micro\Plugin\HttpExceptions;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\HttpExceptions\Configuration\HttpExceptionResponsePluginConfigurationInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class HttpExceptionResponsePluginConfiguration extends PluginConfiguration implements HttpExceptionResponsePluginConfigurationInterface
{
    public const CFG_DECORATED_WEIGHT = 'MICRO_HTTP_EXCEPTION_DECORATION_WEIGHT';

    public const CFG_DECORATION_WEIGHT_DEFAULT = 100;

    public function getDecoratedLevel(): int
    {
        return (int) $this->configuration->get(self::CFG_DECORATED_WEIGHT, self::CFG_DECORATION_WEIGHT_DEFAULT, false);
    }
}
