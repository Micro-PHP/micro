<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit\Business\Route;

use Micro\Plugin\HttpCore\Business\Route\RouteCollection;
use Micro\Plugin\HttpCore\Business\Route\RouteCollectionInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use Micro\Plugin\HttpCore\Exception\RouteAlreadyDeclaredException;
use Micro\Plugin\HttpCore\Exception\RouteNotFoundException;
use PHPUnit\Framework\TestCase;

class RouteCollectionTest extends TestCase
{
    public const ROUTES_DATA = [
        ['test'],
        ['abc'],
        ['xzc'],
    ];

    private RouteCollectionInterface $routeCollection;

    protected function setUp(): void
    {
        $this->routeCollection = new RouteCollection($this->createRoutes());
    }

    protected function createRoutes(): array
    {
        $routes = [];

        foreach (self::ROUTES_DATA as $routeData) {
            $tmpRoute = $this->createMock(RouteInterface::class);

            $tmpRoute->expects($this->any())->method('getName')->willReturn($routeData[0]);
            $tmpRoute->expects($this->any())->method('getUri')->willReturn('/test');
            $tmpRoute->expects($this->any())->method('getMethods')->willReturn([]);
            $tmpRoute->expects($this->any())->method('getController')->willReturn(function () {});
            $tmpRoute->expects($this->any())->method('getParameters')->willReturn([]);

            $routes[] = $tmpRoute;
        }

        return $routes;
    }

    public function testSetRoutes()
    {
        $routesColl = $this->createRoutes();

        $this->assertEquals($this->routeCollection, $this->routeCollection->setRoutes($routesColl));

        $this->assertSameSize(self::ROUTES_DATA, $routesColl);
    }

    public function testGetRoutes()
    {
        $this->assertSameSize(self::ROUTES_DATA, $this->routeCollection->getRoutes());
    }

    public function testGetRouteByName()
    {
        $route = $this->routeCollection->getRouteByName('test');

        $this->assertInstanceOf(RouteInterface::class, $route);
        $this->assertEquals('test', $route->getName());

        $this->expectException(RouteNotFoundException::class);
        $this->routeCollection->getRouteByName('route_name_is_not_exists');
    }

    public function testAddRoute()
    {
        $routes = $this->createRoutes();

        $this->expectException(RouteAlreadyDeclaredException::class);
        $this->routeCollection->addRoute($routes[0]);
    }

    public function testGetRoutesNames()
    {
        $names = $this->routeCollection->getRoutesNames();

        $this->assertIsArray($names);
        $this->assertSameSize(self::ROUTES_DATA, $names);
        $this->assertContains('xzc', $names);
    }

    public function testIterateRoutes()
    {
        $i = 0;

        foreach ($this->routeCollection->iterateRoutes() as $route) {
            ++$i;
            $this->assertInstanceOf(RouteInterface::class, $route);
        }

        $this->assertEquals(\count(self::ROUTES_DATA), $i);
    }
}
