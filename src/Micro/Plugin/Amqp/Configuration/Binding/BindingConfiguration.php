<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Configuration\Binding;

readonly class BindingConfiguration implements BindingConfigurationInterface
{
    public function __construct(
        private string $queue,
        private string $exchange,
        private string $connection
    ) {
    }

    public function getQueueName(): string
    {
        return $this->queue;
    }

    public function getExchangeName(): string
    {
        return $this->exchange;
    }

    public function getConnection(): string
    {
        return $this->connection;
    }
}
