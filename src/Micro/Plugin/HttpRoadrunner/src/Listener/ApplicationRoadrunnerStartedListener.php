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

namespace Micro\Plugin\HttpRoadrunner\Listener;

use Micro\Framework\EventEmitter\EventInterface;
use Micro\Framework\EventEmitter\EventListenerInterface;
use Micro\Framework\KernelApp\Business\Event\ApplicationReadyEventInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Micro\Plugin\HttpRoadrunner\Facade\HttpRoadrunnerFacadeInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Spiral\RoadRunner;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

final readonly class ApplicationRoadrunnerStartedListener implements EventListenerInterface
{
    public function __construct(
        private HttpFacadeInterface $httpFacade,
        private HttpRoadrunnerFacadeInterface $httpRoadrunnerFacade
    ) {
    }

    /**
     * @param ApplicationReadyEventInterface $event
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @throws \JsonException
     */
    public function on(EventInterface $event): void
    {
        $sysenv = $event->systemEnvironment();
        $rrMode = getenv('RR_MODE');
        if ('cli' !== $sysenv || 'http' !== $rrMode) {
            return;
        }

        $httpFoundationFactory = new HttpFoundationFactory();
        $psr17Factory = new Psr17Factory();
        $httpMessageFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);

        $worker = RoadRunner\Worker::create();
        $worker = new RoadRunner\Http\PSR7Worker($worker, $psr17Factory, $psr17Factory, $psr17Factory);
        $i = 0;
        $gcCollectStep = $this->httpRoadrunnerFacade->getGcCollectCyclesCount();
        while ($request = $worker->waitRequest()) {
            try {
                $appRequest = $httpFoundationFactory->createRequest($request);
                $appResponse = $this->httpFacade->execute($appRequest, false);
                $worker->respond($httpMessageFactory->createResponse($appResponse));
            } catch (\Throwable $e) {
                $worker->getWorker()->error((string) $e);
            } finally {
                if (++$i === $gcCollectStep) {
                    gc_collect_cycles();
                }
            }
        }
    }

    public static function supports(EventInterface $event): bool
    {
        return $event instanceof ApplicationReadyEventInterface;
    }
}
