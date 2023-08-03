<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Configuration\Publisher;

interface PublisherConfigurationInterface
{
    public function getName(): string;

    public function getConnection(): string;

    public function getChannel(): string;

    public function getExchange(): string;

    /**
     * Set message content type.
     *
     * Examples: text/plain, application/json
     */
    public function getContentType(): string;

    /**
     * Possible values:
     *      AMQPMessage::DELIVERY_MODE_NON_PERSISTENT,
     *      AMQPMessage::DELIVERY_MODE_PERSISTENT.
     */
    public function getDeliveryMode(): int;
}
