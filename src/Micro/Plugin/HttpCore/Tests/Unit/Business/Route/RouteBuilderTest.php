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

use Micro\Plugin\HttpCore\Business\Route\RouteBuilder;
use Micro\Plugin\HttpCore\Exception\RouteInvalidConfigurationException;
use PHPUnit\Framework\TestCase;

class RouteBuilderTest extends TestCase
{
    public const METHOD_DEFAULTS = [
        'PUT', 'POST', 'PATCH', 'GET', 'DELETE',
    ];

    /**
     * @dataProvider dataProvider
     *
     * @return void
     */
    public function testBuild(
        string|null $routeName,
        callable|null $action,
        string|null $uri,
        string|null $pattern,
        array|null $methods,
        string|null $allowedException
    ) {
        $builder = new RouteBuilder();

        if ($routeName) {
            $builder->setName($routeName);
        }

        if ($action) {
            $builder->setController($action);
        }

        if ($uri) {
            $builder->setUri($uri);
        }

        if ($methods) {
            $builder->setMethods($methods);
        }

        if ($allowedException) {
            $this->expectException($allowedException);
        }

        try {
            $route = $builder->build();
        } catch (RouteInvalidConfigurationException $configurationException) {
            $this->assertNotEmpty($configurationException->getMessages());

            throw $configurationException;
        }

        $this->assertIsCallable($route->getController());
        $this->assertEquals($uri, $route->getUri());
        $this->assertEquals($methods ?: self::METHOD_DEFAULTS, $route->getMethods());
        $this->assertEquals($pattern, $route->getPattern());
        $this->assertEquals($routeName, $route->getName());
    }

    public static function dataProvider(): array
    {
        return [
            ['test', function () {}, '/{test}.{_format}', '/\/(.[aA-zZ0-9-_]+)\.(.[aA-zZ0-9-_]+)$/', ['POST'], null],
            ['test', function () {}, '/{test}-{date}.{_format}', '/\/(.[aA-zZ0-9-_]+)-(.[aA-zZ0-9-_]+)\.(.[aA-zZ0-9-_]+)$/', ['POST'], null],
            [null, function () {}, '/{test}.{_format}', '/\/(.[aA-zZ0-9-_]+)\.(.[aA-zZ0-9-_]+)$/', null, null],
            ['test', null, '/{test}.{_format}', null, null, RouteInvalidConfigurationException::class],
            ['test', function () {}, '/test', null, null, null],
            ['test', null, null, null, null, RouteInvalidConfigurationException::class],
        ];
    }

    public function testClear()
    {
        $builder = new RouteBuilder();

        $routeA = $builder->setName('test')
            ->setController(function () {})
            ->setUri('/{test}.{_format}')
            ->setMethods(['POST'])
            ->build();

        $routeB = $builder->setController(function () {})
            ->setUri('/{test}.{_format}')
            ->setMethods(['POST'])
            ->build();

        $this->assertNotEquals($routeA->getName(), $routeB->getName());
    }
}
