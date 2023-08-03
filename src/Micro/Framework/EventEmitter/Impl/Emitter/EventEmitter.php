<?php

namespace Micro\Framework\EventEmitter\Impl\Emitter;

use Micro\Framework\EventEmitter\EventEmitterInterface;
use Micro\Framework\EventEmitter\EventInterface;
use Micro\Framework\EventEmitter\EventListenerInterface;
use Micro\Framework\EventEmitter\ListenerProviderInterface;

class EventEmitter implements EventEmitterInterface
{
    /**
     * @var ListenerProviderInterface[]
     */
    private array $listenerProviderStorage;

    public function __construct()
    {
        $this->listenerProviderStorage = [];
    }

    public function emit(EventInterface $event): void
    {
        foreach ($this->listenerProviderStorage as $provider) {
            $this->provideEventToEventProvider($provider, $event);
        }
    }

    public function addListenerProvider(ListenerProviderInterface $listenerProvider): EventEmitterInterface
    {
        $this->listenerProviderStorage[] = $listenerProvider;

        return $this;
    }

    private function provideEventToEventProvider(ListenerProviderInterface $provider, EventInterface $event): void
    {
        foreach ($provider->getListenersForEvent($event) as $listener) {
            $this->provideEventToListener($listener, $event);
        }
    }

    private function provideEventToListener(EventListenerInterface $listener, EventInterface $event): void
    {
        $listener->on($event);
    }
}
