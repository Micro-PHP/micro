<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit\Business\Matcher\Route;

use Micro\Plugin\HttpCore\Business\Matcher\Route\RouteMatcher;
use Micro\Plugin\HttpCore\Business\Matcher\Route\RouteMatcherInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class RouteMatcherTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testMatch(array $matchersResults, bool $exceptedResult): void
    {
        $route = $this->createMock(RouteInterface::class);
        $request = $this->createMock(Request::class);

        $matchers = [];
        foreach ($matchersResults as $matcherResult) {
            $tmpMatcher = $this
                ->createMock(RouteMatcherInterface::class);

            $tmpMatcher
                ->expects($this->once())
                ->method('match')
                ->with($route, $request)
                ->willReturn($matcherResult);

            $matchers[] = $tmpMatcher;
        }

        $matcher = new RouteMatcher($matchers);

        $result = $matcher->match($route, $request);

        $this->assertEquals($exceptedResult, $result);
    }

    public static function dataProvider(): array
    {
        return [
            [
                [true, true, false], false,
            ],

            [
                [true, true, true], true,
            ],
        ];
    }
}
