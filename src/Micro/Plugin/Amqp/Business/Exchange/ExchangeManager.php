<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Business\Exchange;

use Micro\Plugin\Amqp\AmqpPluginConfiguration;
use Micro\Plugin\Amqp\Business\Channel\ChannelManagerInterface;

readonly class ExchangeManager implements ExchangeManagerInterface
{
    public function __construct(
        private ChannelManagerInterface $channelManager,
        private AmqpPluginConfiguration $pluginConfiguration
    ) {
    }

    public function exchangeDeclare(string $connectionName, string $exchangeName): void
    {
        $channel = $this->channelManager->getChannel($connectionName);
        $configuration = $this->pluginConfiguration->getExchangeConfiguration($exchangeName);

        $channel->exchange_declare(
            $exchangeName,
            $configuration->getType(),
            $configuration->isPassive(),
            $configuration->isDurable(),
            $configuration->isAutoDelete(),
            $configuration->isInternal(),
            $configuration->isNoWait(),
            $configuration->getArguments(),
            $configuration->getTicket()
        );
    }

    /**
     * @TODO:
     */
    public function configure(): void
    {
        $exchangeList = $this->pluginConfiguration->getExchangeList();
        foreach ($exchangeList as $exchangeName) {
            $exchangeConfig = $this->pluginConfiguration->getExchangeConfiguration($exchangeName);
            $connectionList = $exchangeConfig->getConnectionList();
            foreach ($connectionList as $connectionName) {
                $this->exchangeDeclare($connectionName, $exchangeName);
            }
        }
    }
}
