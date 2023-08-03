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

use Micro\Plugin\Amqp\Business\Message\MessageReceivedInterface;
use Micro\Plugin\Amqp\Exception\Consumer\MessageNackException;

interface ConsumerProcessorInterface
{
    /**
     * @throws MessageNackException
     */
    public function __invoke(MessageReceivedInterface $message): string|null;

    public static function name(): string;
}
