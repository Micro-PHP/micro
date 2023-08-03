<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Configuration\Consumer;

interface ConsumerConfigurationInterface
{
    public function getName(): string;

    public function isNoWait(): bool;

    public function isExclusive(): bool;

    public function isNoAck(): bool;

    public function isNoLocal(): bool;

    public function getQueue(): string;

    public function getChannel(): string;

    public function getConnection(): string;

    public function getTag(): string;
}
