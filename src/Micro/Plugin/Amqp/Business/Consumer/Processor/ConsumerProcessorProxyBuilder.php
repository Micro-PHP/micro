<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Business\Consumer\Processor;

use Micro\Framework\Autowire\AutowireHelperInterface;
use Micro\Plugin\Amqp\Business\Message\MessageReceived;
use Micro\Plugin\Amqp\Business\Message\MessageReceivedInterface;
use Micro\Plugin\Amqp\Exception\Consumer\MessageNackException;
use PhpAmqpLib\Message\AMQPMessage;

readonly class ConsumerProcessorProxyBuilder
{
    public function __construct(
        private AutowireHelperInterface $autowireHelper
    ) {
    }

    /**
     * @param class-string<ConsumerProcessorInterface> $processorClass
     */
    public function createProxy(string $processorClass): \Closure
    {
        $processorAutowiredCallback = $this->autowireHelper->autowire($processorClass);
        $processorAutowired = $processorAutowiredCallback();

        return function (AMQPMessage $message) use ($processorAutowired) {
            $receivedMessage = $this->createMessage($message);
            try {
                $result = $processorAutowired($receivedMessage);
            } catch (MessageNackException $exception) {
                $message->nack(
                    $exception->requeue,
                    $exception->multiple
                );

                return;
            } catch (\Throwable $exception) {
                $message->reject(false);

                throw $exception;
            }

            $properties = $message->get_properties();
            $replyTo = $properties['reply_to'] ?? null;
            $correlationId = $properties['correlation_id'] ?? null;
            if (!$replyTo) {
                $message->ack();

                return;
            }

            $channel = $message->getChannel();
            if (!$channel) {
                throw new \RuntimeException('RPC Error: Channel not found.');
            }

            $rpcResponse = new AMQPMessage(
                $result ?: '',
                [
                    'correlation_id' => $correlationId,
                ]
            );

            $channel->basic_publish(
                $rpcResponse,
                '',
                $replyTo
            );

            $message->ack();
        };
    }

    protected function createMessage(AMQPMessage $amqpMessage): MessageReceivedInterface
    {
        return new MessageReceived(
            $amqpMessage
        );
    }
}
