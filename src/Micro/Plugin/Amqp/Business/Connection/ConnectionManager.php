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

use Micro\Plugin\Amqp\AmqpPluginConfiguration;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConnectionManager implements ConnectionManagerInterface
{
    /**
     * @var array<string, AMQPStreamConnection>
     */
    private array $connections;

    public function __construct(
        private readonly AmqpPluginConfiguration $configuration,
        private readonly ConnectionBuilder $connectionBuilder
    ) {
        $this->connections = [];
    }

    public function getConnection(string $connectionName): AMQPStreamConnection
    {
        if (\array_key_exists($connectionName, $this->connections)) {
            return $this->connections[$connectionName];
        }

        return $this->connections[$connectionName] = $this->createConnection($connectionName);
    }

    protected function createConnection(string $connectionName): AMQPStreamConnection
    {
        return $this->connectionBuilder->createConnection(
            $this->configuration->getConnectionConfiguration($connectionName)
        );
    }

    /**
     * @throws \Exception
     */
    public function closeConnection(string $connectionName): void
    {
        $connection = $this->connections[$connectionName];
        $connection->close();
    }

    /**
     * @throws \Exception
     */
    public function closeConnectionsAll(): void
    {
        foreach (array_keys($this->connections) as $connectionName) {
            $this->closeConnection($connectionName);
        }
    }
}
