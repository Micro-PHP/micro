<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\EventEmitter\Business\Provider;

use Micro\Framework\Autowire\AutowireHelperInterface;
use Micro\Framework\EventEmitter\EventInterface;
use Micro\Framework\EventEmitter\EventListenerInterface;
use Micro\Framework\EventEmitter\ListenerProviderInterface;

readonly class ApplicationListenerProvider implements ListenerProviderInterface
{
    /**
     * @template T of EventListenerInterface
     *
     * @param iterable<class-string<T>> $eventListenersClasses
     */
    public function __construct(
        private AutowireHelperInterface $autowireHelper,
        private iterable $eventListenersClasses,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getListenersForEvent(EventInterface $event): iterable
    {
        foreach ($this->getEventListeners() as $listenerClass) {
            if (!$listenerClass::supports($event)) {
                continue;
            }

            $callback = $this->autowireHelper->autowire($listenerClass);

            yield $callback();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return 'events.listener_provider.default';
    }

    /**
     * {@inheritDoc}
     */
    public function getEventListeners(): iterable
    {
        return $this->eventListenersClasses;
    }
}
