<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Tests\Unit\Consumer;

use Micro\Plugin\Amqp\Business\Consumer\Processor\ConsumerProcessorInterface;
use Micro\Plugin\Amqp\Business\Message\MessageReceivedInterface;

class TestConsumer implements ConsumerProcessorInterface
{
    public function __invoke(MessageReceivedInterface $message): string
    {
        return $message->content();
    }

    public static function name(): string
    {
        return 'test';
    }
}
