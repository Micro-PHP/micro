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

use Micro\Plugin\HttpCore\Business\Matcher\Route\Matchers\UriMatcher;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class UriMatcherTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testMatch(string $requestUri, string $routeUri, string|null $routePattern, bool $excepted, array|null $parameters): void
    {
        $matcher = new UriMatcher();

        $routeMock = $this->createMock(RouteInterface::class);
        $routeMock
            ->expects($this->once())
            ->method('getPattern')
            ->willReturn($routePattern);

        if (null === $routePattern) {
            $routeMock
                ->expects($this->once())
                ->method('getUri')
                ->willReturn($routeUri);
        } else {
            $routeMock
                ->expects($this->never())
                ->method('getUri');
        }

        $requestMock = $this->createMock(Request::class);
        $requestMock
            ->expects($this->once())
            ->method('getPathInfo')
            ->willReturn($requestUri);

        $actual = $matcher->match(
            $routeMock,
            $requestMock,
        );

        $this->assertEquals($excepted, $actual);
    }

    public static function dataProvider(): array
    {
        return [
            ['/test/api.json', '/{first}/{second}.{_format}', '/\/(.[aA-zZ0-9_-]+)\/(.[aA-zZ0-9_-]+)\.(.[aA-zZ0-9_-]+)/', true, ['first', 'second', 'format']],
            ['/test/api.json', '/test/api', null, false, null],
            ['/test/api', '/test/api', null, true, null],
        ];
    }
}
