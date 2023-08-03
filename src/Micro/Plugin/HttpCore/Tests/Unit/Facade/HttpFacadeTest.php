<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit\Facade;

use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorFactoryInterface;
use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorInterface;
use Micro\Plugin\HttpCore\Business\Generator\UrlGeneratorFactoryInterface;
use Micro\Plugin\HttpCore\Business\Matcher\UrlMatcherFactoryInterface;
use Micro\Plugin\HttpCore\Business\Matcher\UrlMatcherInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteBuilderFactoryInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteBuilderInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteCollectionFactoryInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteCollectionInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacade;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpFacadeTest extends TestCase
{
    private Request $request;

    private HttpFacadeInterface $facade;

    protected function setUp(): void
    {
        $this->request = $this->createMock(Request::class);

        $urlMatcherFactory = $this->createMock(UrlMatcherFactoryInterface::class);
        $urlMatcher = $this->createMock(UrlMatcherInterface::class);
        $urlMatcher
            ->expects($this->any())
            ->method('match')
            ->with($this->request)
            ->willReturn($this->createMock(RouteInterface::class));

        $urlMatcherFactory
            ->expects($this->any())
            ->method('create')
            ->willReturn($urlMatcher);

        $routeCollectionFactory = $this->createMock(RouteCollectionFactoryInterface::class);
        $routeCollection = $this->createMock(RouteCollectionInterface::class);
        $routeCollection
            ->expects($this->any())
            ->method('getRoutesNames')
            ->willReturn(['test']);

        $routeCollectionFactory
            ->expects($this->any())
            ->method('create')
            ->willReturn($routeCollection);

        $routeExecutorFactory = $this->createMock(RouteExecutorFactoryInterface::class);
        $routeExecutor = $this->createMock(RouteExecutorInterface::class);
        $routeExecutor
            ->expects($this->any())
            ->method('execute')
            ->willReturn($this->createMock(Response::class));

        $routeExecutorFactory
            ->expects($this->any())
            ->method('create')
            ->willReturn($routeExecutor)
        ;

        $routeBuilderFactory = $this->createMock(RouteBuilderFactoryInterface::class);
        $routeBuilderFactory
            ->expects($this->any())
            ->method('create')
            ->willReturn($this->createMock(RouteBuilderInterface::class));

        $urlGeneratorFactory = $this->createMock(UrlGeneratorFactoryInterface::class);

        $this->facade = new HttpFacade(
            $urlMatcherFactory,
            $routeCollectionFactory,
            $routeExecutorFactory,
            $routeBuilderFactory,
            $urlGeneratorFactory,
        );
    }

    public function testGenerateUrlByRouteName()
    {
        $value = $this->facade->generateUrlByRouteName('test', []);
        $this->assertEquals('', $value);

        $value = $this->facade->generateUrlByRouteName('test');
        $this->assertEquals('', $value);
    }

    public function testCreateRouteBuilder()
    {
        $this->assertInstanceOf(RouteBuilderInterface::class, $this->facade->createRouteBuilder());
    }

    public function testExecute()
    {
        $this->assertInstanceOf(Response::class, $this->facade->execute($this->request));
    }

    public function testMatch()
    {
        $this->assertInstanceOf(RouteInterface::class, $this->facade->match($this->request));
    }

    public function testGetDeclaredRoutesNames()
    {
        $this->assertEquals(['test'], $this->facade->getDeclaredRoutesNames());
    }
}
