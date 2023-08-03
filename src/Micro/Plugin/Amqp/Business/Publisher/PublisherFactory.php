<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Business\Publisher;

use Micro\Plugin\Amqp\AmqpPluginConfiguration;
use Micro\Plugin\Amqp\Business\Channel\ChannelManagerInterface;
use Micro\Plugin\Amqp\Business\Exchange\ExchangeManagerInterface;

readonly class PublisherFactory implements PublisherFactoryInterface
{
    public function __construct(
        private ChannelManagerInterface $channelManager,
        private AmqpPluginConfiguration $pluginConfiguration,
        private ExchangeManagerInterface $exchangeManager
    ) {
    }

    public function create(string $publisherName): PublisherInterface
    {
        $configuration = $this->pluginConfiguration->getPublisherConfiguration($publisherName);
        $channel = $this->channelManager->getChannel($configuration->getConnection());

        $this->exchangeManager->exchangeDeclare($configuration->getConnection(), $configuration->getExchange());
        $channel
            ->queue_bind(
                $configuration->getChannel(),
                $configuration->getExchange()
            );

        return new Publisher(
            $this->channelManager,
            $configuration
        );
    }
}
