<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Business\Consumer\Manager;

use Micro\Framework\Autowire\AutowireHelperFactoryInterface;
use Micro\Plugin\Amqp\AmqpPluginConfiguration;
use Micro\Plugin\Amqp\Business\Channel\ChannelManagerInterface;
use Micro\Plugin\Amqp\Business\Consumer\Processor\ConsumerProcessorInterface;
use Micro\Plugin\Amqp\Business\Consumer\Processor\ConsumerProcessorProxyBuilder;
use Micro\Plugin\Amqp\Configuration\Consumer\ConsumerConfigurationInterface;
use PhpAmqpLib\Channel\AMQPChannel;

readonly class ConsumerManager implements ConsumerManagerInterface
{
    public function __construct(
        private AmqpPluginConfiguration $pluginConfiguration,
        private ChannelManagerInterface $channelManager,
        private AutowireHelperFactoryInterface $autowireHelperFactory
    ) {
    }

    public function consume(string $processorClass): void
    {
        $channel = $this->declareConsumer($processorClass);
        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
    }

    /**
     * {@inheritDoc}
     */
    public function getConsumerList(): iterable
    {
        return [];
    }

    /**
     * @param class-string<ConsumerProcessorInterface> $processorClass
     */
    protected function declareConsumer(string $processorClass): AMQPChannel
    {
        $consumerName = $processorClass::name();

        $cfgConsumer = $this->pluginConfiguration->getConsumerConfiguration($consumerName);
        $cfgQueue = $this->pluginConfiguration->getQueueConfiguration($cfgConsumer->getQueue());

        $channel = $this->channelManager->getChannel(
            $cfgConsumer->getConnection()
        );

        $channel->queue_declare(
            $cfgConsumer->getQueue(),
            $cfgQueue->isPassive(),
            $cfgQueue->isDurable(),
            $cfgQueue->isExclusive(),
            $cfgQueue->isAutoDelete()
        );

        $amqpProcessor = $this->createProcessorProxyBuilder()->createProxy($processorClass);
        $this->appendChannelConsumer($channel, $cfgConsumer, $amqpProcessor);

        return $channel;
    }

    protected function appendChannelConsumer(AMQPChannel $channel, ConsumerConfigurationInterface $configuration, \Closure $processor): string
    {
        return $channel->basic_consume(
            $configuration->getQueue(),
            $configuration->getTag(),
            $configuration->isNoLocal(),
            $configuration->isNoAck(),
            $configuration->isExclusive(),
            $configuration->isNoWait(),
            $processor
        );
    }

    protected function createProcessorProxyBuilder(): ConsumerProcessorProxyBuilder
    {
        return new ConsumerProcessorProxyBuilder($this->autowireHelperFactory->create());
    }
}
