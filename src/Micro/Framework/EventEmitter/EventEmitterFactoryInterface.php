<?php

namespace Micro\Framework\EventEmitter;

interface EventEmitterFactoryInterface
{
    public function create(): EventEmitterInterface;
}
