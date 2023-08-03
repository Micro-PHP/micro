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

use Micro\Framework\Autowire\AutowireHelperFactoryInterface;
use Micro\Plugin\Amqp\Business\Channel\ChannelManager;
use Micro\Plugin\Amqp\Business\Channel\ChannelManagerInterface;
use Micro\Plugin\Amqp\Business\Connection\ConnectionBuilder;
use Micro\Plugin\Amqp\Business\Connection\ConnectionManager;
use Micro\Plugin\Amqp\Business\Connection\ConnectionManagerInterface;
use Micro\Plugin\Amqp\Business\Consumer\Manager\ConsumerManager;
use Micro\Plugin\Amqp\Business\Consumer\Manager\ConsumerManagerInterface;
use Micro\Plugin\Amqp\Business\Exchange\ExchangeManager;
use Micro\Plugin\Amqp\Business\Exchange\ExchangeManagerInterface;
use Micro\Plugin\Amqp\Business\Publisher\PublisherFactory;
use Micro\Plugin\Amqp\Business\Publisher\PublisherFactoryInterface;
use Micro\Plugin\Amqp\Business\Publisher\PublisherManager;
use Micro\Plugin\Amqp\Business\Publisher\PublisherManagerInterface;
use Micro\Plugin\Amqp\Business\Queue\QueueManager;
use Micro\Plugin\Amqp\Business\Rpc\RpcPublisherFactory;
use Micro\Plugin\Amqp\Business\Rpc\RpcPublisherFactoryInterface;
use Micro\Plugin\Uuid\UuidFacadeInterface;

/**
 * @TODO: Need to be refactoring
 */
class PluginComponentBuilder implements PluginComponentBuilderInterface
{
    protected readonly ConnectionManagerInterface $connectionManager;

    protected readonly ChannelManagerInterface $channelManager;

    protected readonly ExchangeManagerInterface $exchangeManager;

    protected readonly QueueManager $queueManager;

    private bool $initialized;

    public function __construct(
        private readonly AmqpPluginConfiguration $configuration,
        private readonly AutowireHelperFactoryInterface $autowireHelperFactory,
        private readonly UuidFacadeInterface $uuidFacade
    ) {
        $this->initialized = false;
        // TODO: Factory for each manager
        $this->connectionManager = new ConnectionManager($this->configuration, new ConnectionBuilder());
        $this->channelManager = new ChannelManager($this->connectionManager, $this->configuration);
        $this->queueManager = new QueueManager($this->channelManager, $this->configuration);
        $this->exchangeManager = new ExchangeManager($this->channelManager, $this->configuration);
    }

    /**
     * {@inheritDoc}
     */
    public function initialize(string $initializeAlias): PluginComponentBuilderInterface
    {
        if ($this->initialized) {
            return $this;
        }

        $this->queueManager->configure();
        $this->exchangeManager->configure();
        $this->queueManager->bindings();

        $this->initialized = true;

        return $this;
    }

    public function getConnectionManager(): ConnectionManagerInterface
    {
        return $this->connectionManager;
    }

    public function createRpcPublisherFactory(): RpcPublisherFactoryInterface
    {
        return new RpcPublisherFactory(
            $this->channelManager,
            $this->exchangeManager,
            $this->uuidFacade,
            $this->configuration
        );
    }

    public function createConsumerManager(): ConsumerManagerInterface
    {
        return new ConsumerManager(
            $this->configuration,
            $this->channelManager,
            $this->autowireHelperFactory
        );
    }

    public function createMessagePublisherManager(): PublisherManagerInterface
    {
        return new PublisherManager($this->createPublisherFactory());
    }

    protected function createPublisherFactory(): PublisherFactoryInterface
    {
        return new PublisherFactory(
            $this->channelManager,
            $this->configuration,
            $this->exchangeManager
        );
    }
}
