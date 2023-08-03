<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit\Business\Matcher\Route\Matchers;

use Micro\Plugin\HttpCore\Business\Matcher\Route\Matchers\MethodMatcher;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class MethodMatcherTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testMatch($routeMethod, $requestMethod): void
    {
        $matcher = new MethodMatcher();

        $routeMock = $this->createMock(RouteInterface::class);
        $routeMock
            ->expects($this->once())
            ->method('getMethods')
            ->willReturn([
                $routeMethod,
            ]);

        $requestMock = $this->createMock(Request::class);
        $requestMock
            ->expects($this->once())
            ->method('getMethod')
            ->willReturn($requestMethod);

        $result = $matcher->match(
            $routeMock,
            $requestMock,
        );

        $this->assertEquals(
            $routeMethod === mb_strtoupper($requestMethod),
            $result
        );
    }

    public static function dataProvider(): array
    {
        return [
            ['GET', 'GET'],
            ['GET', 'get'],
            ['POST', 'get'],
            ['POST', 'post'],
            ['PATCH', 'PUT'],
        ];
    }
}
