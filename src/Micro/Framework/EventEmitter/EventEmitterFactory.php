<?php

namespace Micro\Framework\EventEmitter;

use Micro\Framework\EventEmitter\Impl\Emitter\EventEmitter;

class EventEmitterFactory implements EventEmitterFactoryInterface
{
    public function create(): EventEmitterInterface
    {
        return new EventEmitter();
    }
}
