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

namespace Micro\Plugin\HttpExceptionsDev\Tests\Unit;

use Micro\Framework\BootPluginDependent\Plugin\PluginDependedInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Micro\Plugin\HttpExceptionsDev\HttpExceptionResponseDevPlugin;
use Micro\Plugin\HttpExceptions\HttpExceptionResponsePlugin;
use Micro\Plugin\HttpRouterCode\HttpRouterCodePlugin;
use Micro\Plugin\HttpRouterCode\Plugin\RouteProviderPluginInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class End2EndTest implements RouteProviderPluginInterface, PluginDependedInterface
{
    public function provideRoutes(HttpFacadeInterface $httpFacade): iterable
    {
        yield $httpFacade->createRouteBuilder()
            ->setName('route_500')
            ->setUri('/500')
            ->setController(fn () => throw new \Exception('Hello, i\'m 500 exception'))
            ->build();

        yield $httpFacade->createRouteBuilder()
            ->setName('route_500_1')
            ->setUri('/500_1')
            ->setController(fn () => throw new class('Hello, i\'m 500_1 exception', 0, new \Exception('parent')) extends \Exception {})
            ->build();

        yield $httpFacade->createRouteBuilder()
            ->setName('home')
            ->setUri('/')
            ->setController(fn () => new Response('Hello, world'))
            ->build();
    }

    public function getDependedPlugins(): iterable
    {
        return [
            HttpExceptionResponseDevPlugin::class,
            HttpRouterCodePlugin::class,
            HttpExceptionResponsePlugin::class,
        ];
    }
}
