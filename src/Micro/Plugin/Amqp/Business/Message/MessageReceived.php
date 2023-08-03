<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Business\Message;

use PhpAmqpLib\Message\AMQPMessage;

readonly class MessageReceived implements MessageReceivedInterface
{
    public function __construct(
        private AMQPMessage $source
    ) {
    }

    protected function source(): AMQPMessage
    {
        return $this->source;
    }

    public function content(): string
    {
        return $this->source->getBody();
    }

    public function getOption(string $option, mixed $default = null): mixed
    {
        return $this->source()->get($option) ?: $default;
    }
}
