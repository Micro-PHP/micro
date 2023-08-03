<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Configuration\Exchange;

interface ExchangeConfigurationInterface
{
    public function getType(): string;

    public function isPassive(): bool;

    public function isDurable(): bool;

    public function isAutoDelete(): bool;

    public function isInternal(): bool;

    public function isNoWait(): bool;

    /**
     * @return mixed[]
     */
    public function getArguments(): array;

    public function getTicket(): ?int;

    /**
     * @return string[]
     */
    public function getConnectionList(): array;

    /**
     * @return string[]
     */
    public function getChannelList(): array;
}
