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

namespace Micro\Plugin\HttpRouterCode\Tests\Unit;

use Micro\Framework\BootPluginDependent\Plugin\PluginDependedInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Micro\Plugin\HttpRouterCode\HttpRouterCodePlugin;
use Micro\Plugin\HttpRouterCode\Plugin\RouteProviderPluginInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class HttpTestPlugin implements RouteProviderPluginInterface, PluginDependedInterface
{
    public function provideRoutes(HttpFacadeInterface $httpFacade): iterable
    {
        yield $httpFacade
            ->createRouteBuilder()
            ->setUri('/{parameter}')
            ->setController(function (Request $request) { return new Response('Hello, '.$request->get('parameter')); })
            ->build()
        ;
    }

    public function getDependedPlugins(): iterable
    {
        return [
            HttpRouterCodePlugin::class,
        ];
    }
}
