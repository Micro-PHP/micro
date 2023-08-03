<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\KernelApp\Business\Processor;

use Micro\Framework\EventEmitter\EventInterface;
use Micro\Framework\KernelApp\AppKernelInterface;
use Micro\Framework\KernelApp\Business\Event\ApplicationTerminatedEvent;

class AppCreateEventTerminate extends AbstractEmitEventProcessor
{
    protected function createEvent(AppKernelInterface $appKernel): EventInterface
    {
        return new ApplicationTerminatedEvent();
    }
}
