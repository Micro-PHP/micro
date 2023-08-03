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

namespace Micro\Plugin\HttpMiddleware\Tests\Unit\Decorator;

use Micro\Plugin\HttpCore\Business\Route\RouteBuilderInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Micro\Plugin\HttpMiddleware\Decorator\HttpMiddlewareDecorator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpMiddlewareDecoratorTest extends TestCase
{
    private HttpMiddlewareDecorator $decorator;

    private HttpFacadeInterface $httpFacade;

    private Request $request;

    private Response $response;

    protected function setUp(): void
    {
        $this->httpFacade = $this->createMock(HttpFacadeInterface::class);
        $this->request = $this->createMock(Request::class);
        $this->response = $this->createMock(Response::class);

        $this->httpFacade
            ->expects($this->once())
            ->method('generateUrlByRouteName')
            ->willReturn('generateUrlByRouteName');

        $this->httpFacade
            ->expects($this->once())
            ->method('match')
            ->with($this->request)
            ->willReturn($this->createMock(RouteInterface::class));

        $this->httpFacade
            ->expects($this->once())
            ->method('getDeclaredRoutesNames')
            ->willReturn(['getDeclaredRoutesNames']);

        $this->httpFacade
            ->expects($this->once())
            ->method('createRouteBuilder')
            ->willReturn($this->createMock(RouteBuilderInterface::class));

        $executor = $this->createMock(RouteExecutorInterface::class);
        $executor
            ->expects($this->once())
            ->method('execute')
            ->with($this->request)
            ->willReturn($this->response);

        $routeExecutorFactory = $this->createMock(RouteExecutorFactoryInterface::class);
        $routeExecutorFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($executor);

        $this->decorator = new HttpMiddlewareDecorator(
            $this->httpFacade,
            $routeExecutorFactory
        );
    }

    public function testDecorated()
    {
        $this->assertEquals($this->response, $this->decorator->execute($this->request));
        $this->assertEquals('generateUrlByRouteName', $this->decorator->generateUrlByRouteName('route'));

        $this->assertInstanceOf(RouteInterface::class, $this->decorator->match($this->request));
        $this->assertInstanceOf(RouteBuilderInterface::class, $this->decorator->createRouteBuilder());
        $this->assertEquals(['getDeclaredRoutesNames'], $this->decorator->getDeclaredRoutesNames());
    }
}
