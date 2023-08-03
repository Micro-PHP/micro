<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Configuration\Consumer;

use Micro\Plugin\Amqp\AbstractAmqpComponentConfiguration;

class ConsumerConfiguration extends AbstractAmqpComponentConfiguration implements ConsumerConfigurationInterface
{
    private const CFG_TAG = 'AMQP_CONSUMER_%s_TAG';
    private const CFG_CHANNEL = 'AMQP_CONSUMER_%s_CHANNEL';
    private const CFG_CONNECTION = 'AMQP_CONSUMER_%s_CONNECTION';
    private const CFG_QUEUE = 'AMQP_CONSUMER_%s_QUEUE';
    private const CFG_NO_WAIT = 'AMQP_CONSUMER_%s_NO_WAIT';
    private const CFG_EXCLUSIVE = 'AMQP_CONSUMER_%s_EXCLUSIVE';
    private const CFG_NO_ACK = 'AMQP_CONSUMER_%s_NO_ACK';
    private const CFG_NO_LOCAL = 'AMQP_CONSUMER_%s_NO_LOCAL';

    public function getQueue(): string
    {
        return $this->get(self::CFG_QUEUE, $this->configRoutingKey);
    }

    public function getChannel(): string
    {
        return $this->get(self::CFG_CHANNEL, $this->configRoutingKey);
    }

    public function getConnection(): string
    {
        return $this->get(self::CFG_CONNECTION, 'default');
    }

    public function getTag(): string
    {
        return $this->get(self::CFG_TAG, '');
    }

    public function isNoWait(): bool
    {
        return $this->get(self::CFG_NO_WAIT, false);
    }

    public function isExclusive(): bool
    {
        return $this->get(self::CFG_EXCLUSIVE, false);
    }

    public function isNoAck(): bool
    {
        return $this->get(self::CFG_NO_ACK, false);
    }

    public function isNoLocal(): bool
    {
        return $this->get(self::CFG_NO_LOCAL, false);
    }

    public function getName(): string
    {
        return $this->configRoutingKey;
    }
}
