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

namespace Micro\Plugin\Cache;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\Cache\Configuration\Adapter\CachePoolConfiguration;
use Micro\Plugin\Cache\Configuration\Adapter\CachePoolConfigurationInterface;
use Micro\Plugin\Cache\Configuration\CachePluginConfigurationInterface;

class CachePluginConfiguration extends PluginConfiguration implements CachePluginConfigurationInterface
{
    public function getPoolConfiguration(string $cachePoolName): CachePoolConfigurationInterface
    {
        return new CachePoolConfiguration($this->configuration, $cachePoolName);
    }
}
