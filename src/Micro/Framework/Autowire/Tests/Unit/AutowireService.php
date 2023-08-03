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

namespace Micro\Framework\Autowire\Tests\Unit;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class AutowireService
{
    public function __construct(private AutowireServiceArgument $autowireServiceArgument)
    {
    }

    public function getService(): AutowireServiceArgument
    {
        return $this->autowireServiceArgument;
    }

    public function setService(AutowireServiceArgument $autowireServiceArgument)
    {
        return $this;
    }
}
