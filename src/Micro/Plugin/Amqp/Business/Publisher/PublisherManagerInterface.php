<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Business\Publisher;

interface PublisherManagerInterface
{
    /**
     * @param array<string, mixed> $options
     */
    public function publish(
        string $message,
        string $publisherName,
        string $routingKey = '',
        array $options = []
    ): void;
}
