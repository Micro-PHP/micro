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

interface RedisManagerInterface
{
    /**
     * @throws \RedisException
     */
    public function getClient(string $clientName = RedisPluginConfiguration::CLIENT_DEFAULT): \Redis;
}
