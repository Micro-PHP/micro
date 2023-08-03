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
use Micro\Framework\EventEmitter\ListenerProviderInterface;
use Micro\Plugin\EventEmitter\Business\Locator\EventListenerClassLocatorFactoryInterface;

readonly class ProviderFactory implements ProviderFactoryInterface
{
    public function __construct(
        private AutowireHelperInterface $autowireHelper,
        private EventListenerClassLocatorFactoryInterface $eventListenerClassLocatorFactory
    ) {
    }

    public function create(): ListenerProviderInterface
    {
        $listeners = $this->eventListenerClassLocatorFactory
            ->create()
            ->lookupListenerClasses();

        return new ApplicationListenerProvider(
            $this->autowireHelper,
            $listeners
        );
    }
}
