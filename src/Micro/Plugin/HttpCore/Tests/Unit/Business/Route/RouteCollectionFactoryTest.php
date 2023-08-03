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

use Micro\Plugin\HttpCore\Business\Locator\RouteLocatorFactoryInterface;
use Micro\Plugin\HttpCore\Business\Locator\RouteLocatorInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteCollectionFactory;
use Micro\Plugin\HttpCore\Business\Route\RouteCollectionInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use PHPUnit\Framework\TestCase;

class RouteCollectionFactoryTest extends TestCase
{
    public function testCreate()
    {
        $routes = [];
        $routesCount = 10;
        for ($i = 0; $i < $routesCount; ++$i) {
            $tmpRoute = $this->createMock(RouteInterface::class);

            $tmpRoute->expects($this->any())->method('getName')->willReturn('test_'.rand());
            $tmpRoute->expects($this->any())->method('getUri')->willReturn('test_'.rand());

            $routes[] = $tmpRoute;
        }

        $routeLocator = $this->createMock(RouteLocatorInterface::class);
        $routeLocator
            ->expects($this->once())
            ->method('locate')
            ->willReturn($routes);

        $routeLocatorFactory = $this->createMock(RouteLocatorFactoryInterface::class);
        $routeLocatorFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($routeLocator);

        $factory = new RouteCollectionFactory($routeLocatorFactory);

        $collection = $factory->create();

        $this->assertInstanceOf(RouteCollectionInterface::class, $collection);

        $actualCount = \count($collection->getRoutes());

        $this->assertEquals($routesCount, $actualCount);
    }
}
