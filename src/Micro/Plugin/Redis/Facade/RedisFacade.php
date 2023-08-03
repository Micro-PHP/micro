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

namespace Micro\Plugin\Redis\Facade;

use Micro\Plugin\Redis\Business\Redis\RedisManagerInterface;
use Micro\Plugin\Redis\RedisPluginConfiguration;

readonly class RedisFacade implements RedisFacadeInterface
{
    public function __construct(private RedisManagerInterface $redisManager)
    {
    }

    public function getClient(string $clientName = RedisPluginConfiguration::CLIENT_DEFAULT): \Redis
    {
        return $this->redisManager->getClient($clientName);
    }
}
