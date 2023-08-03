<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Business\Connection;

use PhpAmqpLib\Connection\AMQPStreamConnection;

interface ConnectionManagerInterface
{
    public function getConnection(string $connectionName): AMQPStreamConnection;

    public function closeConnection(string $connectionName): void;

    public function closeConnectionsAll(): void;
}
