<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Facade;

use Micro\Plugin\Amqp\Business\Consumer\Locator\ConsumerLocatorInterface;
use Micro\Plugin\Amqp\Business\Consumer\Manager\ConsumerManagerInterface;
use Micro\Plugin\Amqp\Business\Publisher\PublisherManagerInterface;
use Micro\Plugin\Amqp\Business\Rpc\RpcPublisherInterface;
use Micro\Plugin\Amqp\Configuration\Consumer\ConsumerConfigurationInterface;
use Micro\Plugin\Amqp\Configuration\Publisher\PublisherConfigurationInterface;

interface AmqpFacadeInterface extends ConsumerManagerInterface, PublisherManagerInterface, ConsumerLocatorInterface, RpcPublisherInterface
{
    public function terminate(): void;

    /**
     * @return iterable<ConsumerConfigurationInterface>
     */
    public function getConsumersConfigurationList(): iterable;

    public function getConsumerConfiguration(string $consumerName): ConsumerConfigurationInterface;

    public function getPublisherConfiguration(string $publisherName): PublisherConfigurationInterface;
}
