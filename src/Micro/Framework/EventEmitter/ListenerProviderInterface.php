<?php

namespace Micro\Framework\EventEmitter;

interface ListenerProviderInterface extends \Stringable
{
    /**
     * @return iterable<EventListenerInterface>
     */
    public function getListenersForEvent(EventInterface $event): iterable;

    /**
     * @return iterable<class-string<EventListenerInterface>>
     */
    public function getEventListeners(): iterable;

    public function getName(): string;
}
