<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit\Business\Matcher;

use Micro\Plugin\HttpCore\Business\Matcher\Route\RouteMatcherFactory;
use Micro\Plugin\HttpCore\Business\Matcher\Route\RouteMatcherInterface;
use Micro\Plugin\HttpCore\Business\Matcher\UrlMatcher;
use Micro\Plugin\HttpCore\Business\Route\Route;
use Micro\Plugin\HttpCore\Business\Route\RouteCollectionInterface;
use Micro\Plugin\HttpCore\Exception\HttpNotFoundException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class UrlMatcherTest extends TestCase
{
    public const ROUTES_DATA = [
        [
            'test_dyn',
            '/test/{option}/{test}.{_format}',
            '/\/test\/(.[aA-zZ0-9-_]+)\/(.[aA-zZ0-9-_]+)\.(.[aA-zZ0-9-_]+)/',
            [
                'option', 'test', '_format',
            ],
        ],
        [
            'test_stat',
            '/test/static',
            null,
            null,
        ],
    ];

    /**
     * @dataProvider  dataProvider
     *
     * @return void
     */
    public function testMatch(
        string $routeName,
        string $requestMethod,
        string $requestUrl,
        string|null $allowedException
    ) {
        $matcher = $this->createUrlMatcher();

        $request = Request::create($requestUrl, $requestMethod);

        if ($allowedException) {
            $this->expectException($allowedException);
        }

        $route = $matcher->match($request);

        if ($allowedException) {
            return;
        }

        $this->assertEquals($routeName, $route->getName());
    }

    public static function dataProvider(): array
    {
        return [
            ['test_dyn', 'GET', '/test/option_value/test_value.json', null],
            ['test_dyn', 'POST', '/test/option_value/test_value.json', HttpNotFoundException::class],
            ['test_stat', 'GET', '/test/static', null],
            ['test_stat', 'PATCH', '/test/static', HttpNotFoundException::class],
        ];
    }

    protected function createUrlMatcher(): UrlMatcher
    {
        return new UrlMatcher(
            $this->createRouteMatcher(),
            $this->createRouteCollection(),
        );
    }

    protected function createRouteMatcher(): RouteMatcherInterface
    {
        return (new RouteMatcherFactory())->create();
    }

    protected function createRouteCollection(): RouteCollectionInterface
    {
        $stub = $this->createMock(RouteCollectionInterface::class);

        $routes = [];
        foreach (self::ROUTES_DATA as $routeData) {
            $routes[] = new Route(
                $routeData[1],
                function () {},
                ['GET'],
                $routeData[0],
                $routeData[2],
                $routeData[3]
            );
        }

        $stub
            ->expects($this->once())
            ->method('iterateRoutes')
            ->willReturn($routes);

        return $stub;
    }
}
