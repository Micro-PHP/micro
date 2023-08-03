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

namespace Micro\Plugin\HttpExceptionsDev;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\HttpExceptionsDev\Configuration\HttpExceptionResponseDevPluginConfigurationInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class HttpExceptionResponseDevPluginConfiguration extends PluginConfiguration implements HttpExceptionResponseDevPluginConfigurationInterface
{
    public const CFG_DECORATED_WEIGHT = 'MICRO_HTTP_EXCEPTION_DEV_PAGE_DECORATION_WEIGHT';
    public const DECORATED_DEFAULT = 200;

    public function getProjectDir(): string
    {
        return rtrim($this->configuration->get('BASE_PATH'), '/').'/';
    }

    public function isDevMode(): bool
    {
        $appEnv = $this->configuration->get('APP_ENV', 'dev');

        return str_starts_with($appEnv, 'dev');
    }

    public function getPriorityDecoration(): int
    {
        return (int) $this->configuration->get(self::CFG_DECORATED_WEIGHT, self::DECORATED_DEFAULT);
    }
}
