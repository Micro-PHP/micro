<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp;

use Micro\Plugin\Amqp\Business\Connection\ConnectionManagerInterface;
use Micro\Plugin\Amqp\Business\Consumer\Manager\ConsumerManagerInterface;
use Micro\Plugin\Amqp\Business\Publisher\PublisherManagerInterface;
use Micro\Plugin\Amqp\Business\Rpc\RpcPublisherFactoryInterface;

interface PluginComponentBuilderInterface
{
    public function initialize(string $initializeAlias): self;

    public function createConsumerManager(): ConsumerManagerInterface;

    public function createMessagePublisherManager(): PublisherManagerInterface;

    public function getConnectionManager(): ConnectionManagerInterface;

    public function createRpcPublisherFactory(): RpcPublisherFactoryInterface;
}
