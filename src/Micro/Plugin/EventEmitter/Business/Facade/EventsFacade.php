<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\EventEmitter\Business\Facade;

use Micro\Framework\EventEmitter\EventEmitterFactoryInterface;
use Micro\Framework\EventEmitter\EventInterface;
use Micro\Plugin\EventEmitter\EventsFacadeInterface;

readonly class EventsFacade implements EventsFacadeInterface
{
    public function __construct(
        private EventEmitterFactoryInterface $eventEmitterFactory
    ) {
    }

    public function emit(EventInterface $event): void
    {
        $this->eventEmitterFactory->create()->emit($event);
    }
}
