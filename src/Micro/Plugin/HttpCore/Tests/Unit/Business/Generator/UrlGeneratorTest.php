<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit\Business\Generator;

use Micro\Plugin\HttpCore\Business\Generator\UrlGenerator;
use Micro\Plugin\HttpCore\Business\Route\RouteCollectionInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use PHPUnit\Framework\TestCase;

class UrlGeneratorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testGenerateUrlByRouteName(
        string $routeUri,
        array $routeParameters,
        array|null $parameters,
        string $exceptedRoute,
        string|null $exceptionExcepted
    ) {
        $route = $this->createMock(RouteInterface::class);
        $route
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($routeUri);

        $route
            ->expects($this->once())
            ->method('getParameters')
            ->willReturn($routeParameters);

        $collection = $this->createMock(RouteCollectionInterface::class);
        $collection
            ->expects($this->once())
            ->method('getRouteByName')
            ->with('test_route')
            ->willReturn($route);

        $generator = new UrlGenerator($collection);

        if ($exceptionExcepted) {
            $this->expectException($exceptionExcepted);
        }

        $generated = $generator->generateUrlByRouteName('test_route', $parameters);

        $this->assertEquals($exceptedRoute, $generated);
    }

    public static function dataProvider(): array
    {
        return [
            ['/test', [], [], '/test', null],
            ['/{parameter}', ['parameter'], ['parameter' => 'dynamic'], '/dynamic', null],
            ['/{parameter}', ['parameter'], ['parameter' => 'dynamic', 'invalid_parameter' => 'test'], '', \RuntimeException::class],
            ['/{parameter}', ['parameter'], [], '', \RuntimeException::class],
        ];
    }
}
