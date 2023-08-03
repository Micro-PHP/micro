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

namespace Micro\Plugin\Redis\Business\Redis;

use Micro\Plugin\Redis\RedisPluginConfiguration;
use Micro\Plugin\Redis\RedisPluginConfigurationInterface;

class RedisManager implements RedisManagerInterface
{
    /**
     * @var array<string, \Redis>
     */
    private array $redisCollection;

    public function __construct(
        private readonly RedisFactoryInterface $redisFactory,
        private readonly RedisPluginConfigurationInterface $redisPluginConfiguration
    ) {
        $this->redisCollection = [];
    }

    public function getClient(string $clientName = RedisPluginConfiguration::CLIENT_DEFAULT): \Redis
    {
        if (\array_key_exists($clientName, $this->redisCollection)) {
            return $this->redisCollection[$clientName];
        }

        $config = $this->redisPluginConfiguration->getClientConfiguration($clientName);
        $redis = $this->redisFactory->create($config);

        return $this->redisCollection[$clientName] = $redis;
    }
}
