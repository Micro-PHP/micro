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

use Micro\Plugin\Amqp\Configuration\Connection\ConnectionConfigurationInterface;
use PhpAmqpLib\Connection\AMQPSSLConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConnectionBuilder
{
    public function createConnection(ConnectionConfigurationInterface $configuration): AMQPStreamConnection
    {
        if (!$configuration->sslEnabled()) {
            return $this->createBasicConnection($configuration);
        }

        return $this->createSslConnection($configuration);
    }

    private function createSslConnection(ConnectionConfigurationInterface $configuration): AMQPSSLConnection
    {
        $configuration->validateSslConfiguration();

        return new AMQPSSLConnection(
            $configuration->getHost(),
            $configuration->getPort(),
            $configuration->getUsername(),
            $configuration->getPassword(),
            $configuration->getVirtualHost(),
            $this->createSslOptions($configuration),
            $this->createOptions($configuration)
        );
    }

    /**
     * @return array<string, bool|int|float|string|null>
     */
    private function createOptions(ConnectionConfigurationInterface $configuration): array
    {
        return [
            'insist' => false,
            'login_response' => null,
            'locale' => $configuration->getLocale(),
            'connection_timeout' => $configuration->getConnectionTimeout(),
            'read_write_timeout' => $configuration->getReadWriteTimeout(),
            'keepalive' => $configuration->keepAlive(),
            'heartbeat' => 0,
            'channel_rpc_timeout' => $configuration->getRpcTimeout(),
        ];
    }

    /**
     * @return array<string, string|bool|null>
     */
    private function createSslOptions(ConnectionConfigurationInterface $configuration): array
    {
        return [
            'cafile' => $configuration->getCaCert(),
            'local_pk' => $configuration->getCert(),
            'verify_peer' => $configuration->isVerify(),
        ];
    }

    private function createBasicConnection(ConnectionConfigurationInterface $configuration): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            $configuration->getHost(),
            $configuration->getPort(),
            $configuration->getUsername(),
            $configuration->getPassword(),
            $configuration->getVirtualHost(),
            false,
            $configuration->getSaslMethod(),
            null,
            $configuration->getLocale(),
            $configuration->getConnectionTimeout(),
            $configuration->getReadWriteTimeout(),
            null,
            $configuration->keepAlive(),
            0,
            $configuration->getRpcTimeout(),
            null
        );
    }
}
