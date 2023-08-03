<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\LoggerMonolog\Configuration\Handler\Type;

use Micro\Plugin\LoggerMonolog\Configuration\Handler\HandlerConfigurationInterface;

interface HandlerStreamConfigurationInterface extends HandlerConfigurationInterface
{
    public const TYPE = 'stream';

    public function getLogFile(): string;

    public function useLocking(): bool;
}
