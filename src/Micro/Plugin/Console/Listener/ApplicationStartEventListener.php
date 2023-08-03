<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Console\Listener;

use Micro\Framework\EventEmitter\EventInterface;
use Micro\Framework\EventEmitter\EventListenerInterface;
use Micro\Framework\KernelApp\Business\Event\ApplicationReadyEventInterface;
use Micro\Plugin\Console\Facade\ConsoleApplicationFacadeInterface;

readonly class ApplicationStartEventListener implements EventListenerInterface
{
    public function __construct(
        private ConsoleApplicationFacadeInterface $consoleApplicationFacade,
    ) {
    }

    /**
     * @param ApplicationReadyEventInterface $event
     *
     * @throws \Exception
     */
    public function on(EventInterface $event): void
    {
        if ('cli' !== $event->systemEnvironment()) {
            return;
        }

        $this->consoleApplicationFacade->run();
    }

    public static function supports(EventInterface $event): bool
    {
        return $event instanceof ApplicationReadyEventInterface;
    }
}
