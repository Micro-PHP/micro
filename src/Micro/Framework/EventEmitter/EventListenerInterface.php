<?php

namespace Micro\Framework\EventEmitter;

interface EventListenerInterface
{
    public function on(EventInterface $event): void;

    public static function supports(EventInterface $event): bool;
}
