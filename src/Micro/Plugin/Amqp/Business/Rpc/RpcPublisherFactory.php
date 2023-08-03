<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Business\Rpc;

use Micro\Plugin\Amqp\AmqpPluginConfiguration;
use Micro\Plugin\Amqp\Business\Channel\ChannelManagerInterface;
use Micro\Plugin\Amqp\Business\Exchange\ExchangeManagerInterface;
use Micro\Plugin\Uuid\UuidFacadeInterface;

readonly class RpcPublisherFactory implements RpcPublisherFactoryInterface
{
    public function __construct(
        private ChannelManagerInterface $channelManager,
        private ExchangeManagerInterface $exchangeManager,
        private UuidFacadeInterface $uuidFacade,
        private AmqpPluginConfiguration $amqpPluginConfiguration
    ) {
    }

    public function create(): RpcPublisherInterface
    {
        return new RpcPublisher(
            $this->channelManager,
            $this->uuidFacade,
            $this->exchangeManager,
            $this->amqpPluginConfiguration
        );
    }
}
