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

namespace Micro\Plugin\HttpExceptions\Tests\Unit\Decorator;

use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorFactoryInterface;
use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteBuilderInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use Micro\Plugin\HttpExceptions\Decorator\ExceptionResponseBuilderDecorator;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author ChatGPT Jan 9 Version
 */
class ExceptionResponseBuilderDecoratorTest extends TestCase
{
    private $decorated;
    private $routeExecutorFactory;
    private $decorator;

    protected function setUp(): void
    {
        $this->decorated = $this->createMock(HttpFacadeInterface::class);
        $this->routeExecutorFactory = $this->createMock(RouteExecutorFactoryInterface::class);
        $this->decorator = new ExceptionResponseBuilderDecorator($this->decorated, $this->routeExecutorFactory);
    }

    public function testGetDeclaredRoutesNames()
    {
        $this->decorated->expects($this->once())
            ->method('getDeclaredRoutesNames')
            ->willReturn(['route1', 'route2']);

        $routeExecutorFactoryMock = $this->createMock(RouteExecutorFactoryInterface::class);

        $decorator = new ExceptionResponseBuilderDecorator($this->decorated, $routeExecutorFactoryMock);
        $this->assertEquals(['route1', 'route2'], $decorator->getDeclaredRoutesNames());
    }

    public function testCreateRouteBuilder()
    {
        $routeBuilderMock = $this->createMock(RouteBuilderInterface::class);

        $this->decorated->expects($this->once())
            ->method('createRouteBuilder')
            ->willReturn($routeBuilderMock);

        $routeExecutorFactoryMock = $this->createMock(RouteExecutorFactoryInterface::class);

        $decorator = new ExceptionResponseBuilderDecorator($this->decorated, $routeExecutorFactoryMock);
        $this->assertEquals($routeBuilderMock, $decorator->createRouteBuilder());
    }

    public function testExecute()
    {
        $request = new Request();
        $response = new Response();

        $routeExecutorMock = $this->createMock(RouteExecutorInterface::class);
        $routeExecutorMock->expects($this->once())
            ->method('execute')
            ->with($request, true)
            ->willReturn($response);

        $routeExecutorFactoryMock = $this->createMock(RouteExecutorFactoryInterface::class);
        $routeExecutorFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($routeExecutorMock);

        $decoratedMock = $this->createMock(HttpFacadeInterface::class);

        $decorator = new ExceptionResponseBuilderDecorator($decoratedMock, $routeExecutorFactoryMock);
        $this->assertEquals($response, $decorator->execute($request, true));
    }

    public function testGenerateUrlByRouteName()
    {
        $routeName = 'routeName';
        $parameters = ['param1' => 'value1'];

        $this->decorated->expects($this->once())
            ->method('generateUrlByRouteName')
            ->with($routeName, $parameters)
            ->willReturn('http://example.com');

        $result = $this->decorator->generateUrlByRouteName($routeName, $parameters);

        $this->assertSame('http://example.com', $result);
    }

    public function testMatch()
    {
        $request = $this->createMock(Request::class);
        $route = $this->createMock(RouteInterface::class);

        $this->decorated->expects($this->once())
            ->method('match')
            ->with($request)
            ->willReturn($route);

        $result = $this->decorator->match($request);

        $this->assertSame($route, $result);
    }
}
