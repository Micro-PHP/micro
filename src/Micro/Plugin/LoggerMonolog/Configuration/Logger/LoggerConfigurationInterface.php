<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\LoggerMonolog\Configuration\Logger;

interface LoggerConfigurationInterface
{
    /**
     * @return iterable<string>
     */
    public function getHandlerList(): iterable;

    public function getName(): string;
}
