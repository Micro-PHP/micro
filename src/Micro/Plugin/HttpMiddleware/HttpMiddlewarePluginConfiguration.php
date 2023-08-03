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

namespace Micro\Plugin\HttpMiddleware;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\HttpMiddleware\Configuration\HttpMiddlewarePluginConfigurationInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class HttpMiddlewarePluginConfiguration extends PluginConfiguration implements HttpMiddlewarePluginConfigurationInterface
{
    public const CFG_DECORATION_PRIORITY = 'HTTP_MIDDLEWARE_DECORATION_PRIORITY';

    public const CFG_DECORATION_DEFAULT = 150;

    public function getDecorationPriority(): int
    {
        return (int) $this->configuration->get(self::CFG_DECORATION_PRIORITY, self::CFG_DECORATION_DEFAULT, false);
    }
}
