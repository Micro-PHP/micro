<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpBoot\Listener;

use Micro\Framework\EventEmitter\EventInterface;
use Micro\Framework\EventEmitter\EventListenerInterface;
use Micro\Framework\KernelApp\Business\Event\ApplicationReadyEvent;
use Micro\Framework\KernelApp\Business\Event\ApplicationReadyEventInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class ApplicationStartedListener implements EventListenerInterface
{
    public function __construct(
        private HttpFacadeInterface $httpFacade
    ) {
    }

    /**
     * @param ApplicationReadyEvent $event
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function on(EventInterface $event): void
    {
        $sysenv = $event->systemEnvironment();
        if ('cli' === $sysenv) {
            return;
        }

        $request = Request::createFromGlobals();

        $this->httpFacade->execute($request);
    }

    public static function supports(EventInterface $event): bool
    {
        return $event instanceof ApplicationReadyEventInterface;
    }
}
