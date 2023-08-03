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

use Micro\Framework\BootConfiguration\Configuration\PluginConfigurationInterface;
use Micro\Plugin\Redis\Configuration\RedisClientConfigurationInterface;

interface RedisPluginConfigurationInterface extends PluginConfigurationInterface
{
    /**
     * @param string $clientName
     *
     * @return RedisClientConfigurationInterface
     */
    public function getClientConfiguration(string $clientName): RedisClientConfigurationInterface;
}
