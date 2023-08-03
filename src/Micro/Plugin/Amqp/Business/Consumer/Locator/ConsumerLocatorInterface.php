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

namespace Micro\Plugin\Amqp\Business\Consumer\Locator;

use Micro\Plugin\Amqp\Business\Consumer\Processor\ConsumerProcessorInterface;

interface ConsumerLocatorInterface
{
    /**
     * @return class-string<ConsumerProcessorInterface>
     */
    public function locateConsumer(string $consumerName): string;

    /**
     * @return iterable<class-string<ConsumerProcessorInterface>>
     */
    public function locateConsumers(): iterable;
}
