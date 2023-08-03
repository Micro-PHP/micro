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

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\Amqp\Configuration\Channel\ChannelConfiguration;
use Micro\Plugin\Amqp\Configuration\Channel\ChannelConfigurationInterface;
use Micro\Plugin\Amqp\Configuration\Connection\ConnectionConfiguration;
use Micro\Plugin\Amqp\Configuration\Connection\ConnectionConfigurationInterface;
use Micro\Plugin\Amqp\Configuration\Consumer\ConsumerConfiguration;
use Micro\Plugin\Amqp\Configuration\Consumer\ConsumerConfigurationInterface;
use Micro\Plugin\Amqp\Configuration\Exchange\ExchangeConfiguration;
use Micro\Plugin\Amqp\Configuration\Exchange\ExchangeConfigurationInterface;
use Micro\Plugin\Amqp\Configuration\Publisher\PublisherConfiguration;
use Micro\Plugin\Amqp\Configuration\Publisher\PublisherConfigurationInterface;
use Micro\Plugin\Amqp\Configuration\Queue\QueueConfiguration;
use Micro\Plugin\Amqp\Configuration\Queue\QueueConfigurationInterface;

class AmqpPluginConfiguration extends PluginConfiguration
{
    private const CFG_QUEUE_LIST = 'AMQP_QUEUE_LIST';
    private const CFG_EXCHANGE_LIST = 'AMQP_EXCHANGE_LIST';
    private const CFG_CHANNEL_LIST = 'AMQP_CHANNEL_LIST';
    public const EXCHANGE_DEFAULT = 'default';
    public const QUEUE_DEFAULT = 'default';
    public const CHANNEL_DEFAULT = 'default';
    public const CONNECTION_DEFAULT = 'default';
    public const PUBLISHER_DEFAULT = 'default';

    public function getPublisherConfiguration(string $publisherName): PublisherConfigurationInterface
    {
        return new PublisherConfiguration($this->configuration, $publisherName);
    }

    public function getConsumerConfiguration(string $consumerName): ConsumerConfigurationInterface
    {
        return new ConsumerConfiguration($this->configuration, $consumerName);
    }

    public function getConnectionConfiguration(string $connectionName): ConnectionConfigurationInterface
    {
        return new ConnectionConfiguration($this->configuration, $connectionName);
    }

    public function getQueueConfiguration(string $queueName): QueueConfigurationInterface
    {
        return new QueueConfiguration($this->configuration, $queueName);
    }

    public function getExchangeConfiguration(string $exchangeName): ExchangeConfigurationInterface
    {
        return new ExchangeConfiguration($this->configuration, $exchangeName);
    }

    public function getChannelConfiguration(string $channelName): ChannelConfigurationInterface
    {
        return new ChannelConfiguration($this->configuration, $channelName);
    }

    /**
     * @return string[]
     */
    public function getExchangeList(): array
    {
        $list = $this->configuration->get(self::CFG_EXCHANGE_LIST, self::EXCHANGE_DEFAULT);

        return $this->explodeStringToArray($list);
    }

    /**
     * @return string[]
     */
    public function getQueueList(): array
    {
        $list = $this->configuration->get(self::CFG_QUEUE_LIST, [self::QUEUE_DEFAULT]);

        return $this->explodeStringToArray($list);
    }

    /**
     * @return string[]
     */
    public function getChannelList(): array
    {
        $list = $this->configuration->get(self::CFG_CHANNEL_LIST, [self::CHANNEL_DEFAULT]);

        return $this->explodeStringToArray($list);
    }
}
