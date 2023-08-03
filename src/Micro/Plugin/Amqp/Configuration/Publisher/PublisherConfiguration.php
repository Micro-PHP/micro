<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Configuration\Publisher;

use Micro\Plugin\Amqp\AbstractAmqpComponentConfiguration;
use Micro\Plugin\Amqp\AmqpPluginConfiguration;
use PhpAmqpLib\Message\AMQPMessage;

class PublisherConfiguration extends AbstractAmqpComponentConfiguration implements PublisherConfigurationInterface
{
    private const CFG_CONNECTION = 'AMQP_PUBLISHER_%s_CONNECTION';
    private const CFG_CHANNEL = 'AMQP_PUBLISHER_%s_CHANNEL';
    private const CFG_EXCHANGE = 'AMQP_PUBLISHER_%s_EXCHANGE';
    private const CFG_CONTENT_TYPE = 'AMQP_PUBLISHER_%s_CONTENT_TYPE';
    private const CFG_DELIVERY_MODE = 'AMQP_PUBLISHER_%s_DELIVERY_MODE';

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->configRoutingKey;
    }

    /**
     * {@inheritDoc}
     */
    public function getConnection(): string
    {
        return $this->get(self::CFG_CONNECTION, AmqpPluginConfiguration::CONNECTION_DEFAULT);
    }

    /**
     * {@inheritDoc}
     */
    public function getChannel(): string
    {
        return $this->get(self::CFG_CHANNEL, $this->configRoutingKey);
    }

    /**
     * {@inheritDoc}
     */
    public function getExchange(): string
    {
        return $this->get(self::CFG_EXCHANGE, $this->configRoutingKey);
    }

    /**
     * {@inheritDoc}
     */
    public function getContentType(): string
    {
        return $this->get(self::CFG_CONTENT_TYPE, 'text/plain');
    }

    public function getDeliveryMode(): int
    {
        $deliveryModeString = $this->get(self::CFG_DELIVERY_MODE, 'DELIVERY_MODE_PERSISTENT');

        return \constant(AMQPMessage::class.'::'.$deliveryModeString);
    }
}
