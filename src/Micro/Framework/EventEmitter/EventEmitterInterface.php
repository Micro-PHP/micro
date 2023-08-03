<?php

namespace Micro\Framework\EventEmitter;

interface EventEmitterInterface
{
    public function emit(EventInterface $event): void;

    public function addListenerProvider(ListenerProviderInterface $listenerProvider): self;
}
