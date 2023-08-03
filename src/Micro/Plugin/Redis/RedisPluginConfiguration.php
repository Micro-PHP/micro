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

namespace Micro\Plugin\Redis;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\Redis\Configuration\RedisClientConfiguration;
use Micro\Plugin\Redis\Configuration\RedisClientConfigurationInterface;

class RedisPluginConfiguration extends PluginConfiguration implements RedisPluginConfigurationInterface
{
    public const CLIENT_DEFAULT = 'default';

    public function getClientConfiguration(string $clientName): RedisClientConfigurationInterface
    {
        return new RedisClientConfiguration($this->configuration, $clientName);
    }
}
