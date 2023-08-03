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

use Micro\Plugin\Amqp\Business\Consumer\Processor\ConsumerProcessorInterface;

interface ConsumerManagerInterface
{
    /**
     * @param class-string<ConsumerProcessorInterface> $processorClass
     *
     * @throws \ErrorException
     */
    public function consume(string $processorClass): void;

    /**
     * @return iterable<string>
     */
    public function getConsumerList(): iterable;
}
