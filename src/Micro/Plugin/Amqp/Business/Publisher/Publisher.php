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

use Micro\Plugin\Amqp\Business\Channel\ChannelManagerInterface;
use Micro\Plugin\Amqp\Configuration\Publisher\PublisherConfigurationInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

readonly class Publisher implements PublisherInterface
{
    public function __construct(
        private ChannelManagerInterface $channelManager,
        private PublisherConfigurationInterface $publisherConfiguration
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function publish(string $message, string $routingKey = '', array $options = []): void
    {
        $channel = $this->getChannel();

        $channel->basic_publish(
            $this->createAmqpMessage($message, $options),
            $this->publisherConfiguration->getExchange(),
            $routingKey
        );

        $channel->close();
    }

    protected function getChannel(): AMQPChannel
    {
        return $this->channelManager->getChannel(
            $this->publisherConfiguration->getConnection()
        );
    }

    /**
     * @param array<string, mixed> $options
     */
    protected function createAmqpMessage(string $message, array $options = []): AMQPMessage
    {
        return new AMQPMessage($message, array_merge([
            'content_type' => $this->publisherConfiguration->getContentType(),
            'delivery_mode' => $this->publisherConfiguration->getDeliveryMode(),
        ], $options));
    }
}
