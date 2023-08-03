<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Configuration\Binding;

interface BindingConfigurationInterface
{
    public function getQueueName(): string;

    public function getExchangeName(): string;

    public function getConnection(): string;
}
