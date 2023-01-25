<?php

declare(strict_types=1);

namespace App\Acme;

use Micro\Plugin\Http\Facade\HttpFacadeInterface;
use Micro\Plugin\Http\Plugin\RouteProviderPluginInterface;
use Symfony\Component\HttpFoundation\Response;

class AcmePlugin implements RouteProviderPluginInterface
{
    public function provideRoutes(HttpFacadeInterface $httpFacade): iterable
    {
        yield $httpFacade
            ->createRouteBuilder()
            ->setName('index')
            ->setUri('/')
            ->setController(fn () => new Response('Hello, World. I\'m MicroPHP!'))
            ->build();
    }
}
