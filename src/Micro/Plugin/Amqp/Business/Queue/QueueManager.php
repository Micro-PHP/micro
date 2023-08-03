<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Business\Queue;

use Micro\Plugin\Amqp\AmqpPluginConfiguration;
use Micro\Plugin\Amqp\Business\Channel\ChannelManagerInterface;

readonly class QueueManager implements QueueManagerInterface
{
    public function __construct(
        private ChannelManagerInterface $channelManager,
        private AmqpPluginConfiguration $pluginConfiguration
    ) {
    }

    public function queueDeclare(string $connectionName, string $queueName): void
    {
        $queueConfiguration = $this->pluginConfiguration->getQueueConfiguration($queueName);
        $channel = $this->channelManager->getChannel($connectionName);
        $channel->queue_declare(
            $queueConfiguration->getName(),
            $queueConfiguration->isPassive(),
            $queueConfiguration->isDurable(),
            $queueConfiguration->isExclusive(),
            $queueConfiguration->isAutoDelete()
        );
    }

    /**
     * @TODO:
     */
    public function configure(): void
    {
        $queueList = $this->pluginConfiguration->getQueueList();

        foreach ($queueList as $queueName) {
            $queueConfiguration = $this->pluginConfiguration->getQueueConfiguration($queueName);
            $connectionList = $queueConfiguration->getConnectionList();

            foreach ($connectionList as $connectionName) {
                $this->queueDeclare($connectionName, $queueConfiguration->getName());
            }
        }
    }

    public function bindings(): void
    {
        $channels = $this->pluginConfiguration->getChannelList();

        foreach ($channels as $channelName) {
            $this->channelBind($channelName);
        }
    }

    protected function channelBind(string $channelName): void
    {
        $configuration = $this->pluginConfiguration->getChannelConfiguration($channelName);
        $bindings = $configuration->getBindings();

        foreach ($bindings as $binding) {
            $channel = $this->channelManager->getChannel(
                $binding->getConnection()
            );

            $channel->queue_bind(
                $binding->getQueueName(),
                $binding->getExchangeName()
            );
        }
    }
}
