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
use Micro\Plugin\Amqp\Configuration\Channel\ChannelConfigurationInterface;
use Micro\Plugin\Amqp\Configuration\Publisher\PublisherConfigurationInterface;
use Micro\Plugin\Uuid\UuidFacadeInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class RpcPublisher implements RpcPublisherInterface
{
    private const OPT_CORRELATION_ID = 'correlation_id';

    private const OPT_REPLY_TO = 'reply_to';

    private string $callbackQueue = '';

    private string $response = '';

    private string $correlationId = '';

    public function __construct(
        private readonly ChannelManagerInterface $channelManager,
        private readonly UuidFacadeInterface $uuidFacade,
        private readonly ExchangeManagerInterface $exchangeManager,
        private readonly AmqpPluginConfiguration $amqpPluginConfiguration
    ) {
    }

    public function rpc(string $message, string $publisherName): string
    {
        $publisherConfiguration = $this->amqpPluginConfiguration->getPublisherConfiguration($publisherName);
        $channelCfg = $this->amqpPluginConfiguration->getChannelConfiguration($publisherConfiguration->getChannel());
        $channel = $this->initialize($publisherConfiguration, $channelCfg);

        $msg = new AMQPMessage($message, [
            self::OPT_CORRELATION_ID => $this->correlationId,
            self::OPT_REPLY_TO => $this->callbackQueue,
        ]);

        $channel->basic_publish($msg, $publisherName);

        // TODO: configurable timeout
        $channel->wait(
            null,
            false,
            $channelCfg->getRpcTimeout(),
        );

        $channel->close();

        return $this->response;
    }

    public function onResponse(AMQPMessage $rep): void
    {
        try {
            $correlationId = $rep->get(self::OPT_CORRELATION_ID);
        } catch (\OutOfBoundsException $exception) {
            $rep->nack(true);

            return;
        }

        if ($correlationId === $this->correlationId) {
            $this->response = $rep->body;
        }
    }

    protected function initialize(
        PublisherConfigurationInterface $publisherConfiguration,
        ChannelConfigurationInterface $channelConfiguration
    ): AMQPChannel {
        $publisherName = $publisherConfiguration->getName();
        $connectionName = $publisherConfiguration->getConnection();

        $channel = $this->channelManager->getChannel($connectionName);
        $this->response = '';
        $this->correlationId = $this->uuidFacade->v4();

        $declared = $channel->queue_declare(
            '',
            false,
            false,
            true,
            true,
            false,
            [
                'x-message-ttl' => $channelConfiguration->getRpcTimeout() * 1000, // Timeout * Milliseconds
            ]
        );

        if (!$declared) {
            throw new \RuntimeException(sprintf('Queue can not be declared for the publisher `%s`', $publisherName));
        }

        list($this->callbackQueue) = $declared;

        /* @psalm-suppress PossiblyNullArgument */
        $channel->basic_consume(
            $this->callbackQueue,
            '',
            false,
            true,
            false,
            false,
            [
                $this,
                'onResponse',
            ]
        );

        $this->exchangeManager->exchangeDeclare($connectionName, $publisherName);
        $channel->queue_bind($this->callbackQueue, $publisherName, 'rpc_response');
        $channel->queue_bind($publisherName, $publisherName);

        return $channel;
    }
}
