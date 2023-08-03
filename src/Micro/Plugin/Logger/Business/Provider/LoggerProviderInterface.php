<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Logger\Business\Provider;

use Micro\Plugin\Logger\Exception\LoggerAdapterNotRegisteredException;
use Psr\Log\LoggerInterface;

interface LoggerProviderInterface
{
    /**
     * @throws LoggerAdapterNotRegisteredException
     */
    public function getLogger(string $loggerName): LoggerInterface;
}
