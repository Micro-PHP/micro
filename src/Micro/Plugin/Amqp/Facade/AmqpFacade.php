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

use Micro\Plugin\Amqp\AmqpPluginConfiguration;
use Micro\Plugin\Amqp\Business\Consumer\Locator\ConsumerLocatorFactoryInterface;
use Micro\Plugin\Amqp\Business\Consumer\Manager\ConsumerManagerInterface;
use Micro\Plugin\Amqp\Business\Publisher\PublisherManagerInterface;
use Micro\Plugin\Amqp\Configuration\Consumer\ConsumerConfigurationInterface;
use Micro\Plugin\Amqp\Configuration\Publisher\PublisherConfigurationInterface;
use Micro\Plugin\Amqp\PluginComponentBuilderInterface;

class AmqpFacade implements AmqpFacadeInterface
{
    private ConsumerManagerInterface $consumerManager;

    private PublisherManagerInterface $publisherManager;

    public function __construct(
        private readonly PluginComponentBuilderInterface $pluginComponentBuilder,
        private readonly ConsumerLocatorFactoryInterface $consumerLocatorFactory,
        private readonly AmqpPluginConfiguration $amqpPluginConfiguration
    ) {
        $this->consumerManager = $this->pluginComponentBuilder->createConsumerManager();
        $this->publisherManager = $this->pluginComponentBuilder->createMessagePublisherManager();
    }

    public function consume(string $processorClass): void
    {
        $this->consumerManager->consume($processorClass);
    }

    public function publish(
        string $message,
        string $publisherName = AmqpPluginConfiguration::PUBLISHER_DEFAULT,
        string $routingKey = '',
        array $options = []
    ): void {
        $this->publisherManager->publish($message, $publisherName, $routingKey, $options);
    }

    public function terminate(): void
    {
        $this->pluginComponentBuilder->getConnectionManager()->closeConnectionsAll();
    }

    public function getConsumersConfigurationList(): iterable
    {
        foreach ($this->getConsumerList() as $consumerName) {
            yield $this->amqpPluginConfiguration->getConsumerConfiguration($consumerName);
        }
    }

    public function getConsumerList(): iterable
    {
        return $this->consumerManager->getConsumerList();
    }

    public function getConsumerConfiguration(string $consumerName): ConsumerConfigurationInterface
    {
        return $this->amqpPluginConfiguration->getConsumerConfiguration($consumerName);
    }

    public function getPublisherConfiguration(string $publisherName): PublisherConfigurationInterface
    {
        return $this->amqpPluginConfiguration->getPublisherConfiguration($publisherName);
    }

    public function rpc(string $message, string $publisherName): string
    {
        return $this->pluginComponentBuilder
            ->createRpcPublisherFactory()
            ->create()
            ->rpc($message, $publisherName);
    }

    public function locateConsumer(string $consumerName): string
    {
        return $this->consumerLocatorFactory->create()->locateConsumer($consumerName);
    }

    public function locateConsumers(): iterable
    {
        yield from $this->consumerLocatorFactory->create()->locateConsumers();
    }
}
