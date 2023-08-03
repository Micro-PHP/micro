<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Configuration\Exchange;

use Micro\Plugin\Amqp\AbstractAmqpComponentConfiguration;
use Micro\Plugin\Amqp\AmqpPluginConfiguration;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class ExchangeConfiguration extends AbstractAmqpComponentConfiguration implements ExchangeConfigurationInterface
{
    private const CFG_TYPE = 'AMQP_EXCHANGE_%s_TYPE';
    private const CFG_IS_PASSIVE = 'AMQP_EXCHANGE_%s_PASSIVE';
    private const CFG_IS_DURABLE = 'AMQP_EXCHANGE_%s_DURABLE';
    private const CFG_IS_AUTO_DELETE = 'AMQP_EXCHANGE_%s_AUTO_DELETE';
    private const CFG_IS_INTERNAL = 'AMQP_EXCHANGE_%s_INTERNAL';
    private const CFG_IS_NO_WAIT = 'AMQP_EXCHANGE_%s_NO_WAIT';
    private const CFG_TICKET = 'AMQP_EXCHANGE_%s_TICKET';
    private const CFG_CHANNELS = 'AMQP_EXCHANGE_%s_CHANNELS';
    private const CFG_CONNECTIONS = 'AMQP_EXCHANGE_%s_CONNECTIONS';

    public function getType(): string
    {
        $type = mb_strtoupper($this->get(self::CFG_TYPE, 'DIRECT'));

        return \constant(AMQPExchangeType::class.'::'.$type);
    }

    public function isPassive(): bool
    {
        return $this->get(self::CFG_IS_PASSIVE, false);
    }

    public function isDurable(): bool
    {
        return $this->get(self::CFG_IS_DURABLE, true);
    }

    public function isAutoDelete(): bool
    {
        return $this->get(self::CFG_IS_AUTO_DELETE, false);
    }

    public function isInternal(): bool
    {
        return $this->get(self::CFG_IS_INTERNAL, false);
    }

    public function isNoWait(): bool
    {
        return $this->get(self::CFG_IS_NO_WAIT, true);
    }

    /**
     * {@inheritDoc}
     *
     * @TODO:
     */
    public function getArguments(): array
    {
        return [];
    }

    public function getTicket(): ?int
    {
        $value = $this->get(self::CFG_TICKET);

        return $value ? (int) $value : null;
    }

    public function getConnectionList(): array
    {
        $connectionList = $this->get(self::CFG_CONNECTIONS, AmqpPluginConfiguration::CONNECTION_DEFAULT);

        return $this->explodeStringToArray($connectionList);
    }

    public function getChannelList(): array
    {
        $channelList = $this->get(self::CFG_CHANNELS, AmqpPluginConfiguration::CHANNEL_DEFAULT);

        return $this->explodeStringToArray($channelList);
    }
}
