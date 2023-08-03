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

namespace Micro\Plugin\HttpCore;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\HttpCore\Configuration\HttpCorePluginConfigurationInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class HttpCorePluginConfiguration extends PluginConfiguration implements HttpCorePluginConfigurationInterface
{
    public const CFG_LOCATOR_TYPE_DEFAULT = 'code';
    public const CFG_LOCATOR_TYPE = 'MICRO_HTTP_ROUTE_LOCATOR';

    public function getRouteLocatorType(): string
    {
        return $this->configuration->get(self::CFG_LOCATOR_TYPE, self::CFG_LOCATOR_TYPE_DEFAULT, false);
    }
}
