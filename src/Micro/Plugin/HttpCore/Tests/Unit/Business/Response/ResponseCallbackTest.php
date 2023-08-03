<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit\Business\Response;

use Micro\Framework\Autowire\AutowireHelperInterface;
use Micro\Plugin\HttpCore\Business\Response\Callback\ResponseCallback;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use Micro\Plugin\HttpCore\Exception\RouteInvalidConfigurationException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ResponseCallbackTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testInvoke(
        mixed $routeController,
        string $routeName,
        array $expectedAutoWireArguments,
        array $autowireReturns
    ) {
        $route = $this->createMock(RouteInterface::class);
        $route->expects($this->once())
            ->method('getController')
            ->willReturn($routeController);

        $route->expects($this->any())
            ->method('getName')
            ->willReturn($routeName);

        $autowireHelper = $this->createMock(AutowireHelperInterface::class);
        $autowireHelper->expects($this->any())
            ->method('autowire')
            ->withConsecutive(...$expectedAutoWireArguments)
            ->willReturnOnConsecutiveCalls(...$autowireReturns);

        $responseCallback = new ResponseCallback(
            $autowireHelper,
            $route,
        );

        $this->assertInstanceOf(Response::class, $responseCallback());
    }

    public function dataProvider(): array
    {
        $anonymousFunction = function () { return new Response(); };
        $callbackTestObj = new CallbackTest();

        return [
            [
                'routeController' => $anonymousFunction,
                'routeName' => 'does-not-matter',
                'autoWireArguments' => [[$anonymousFunction]],
                'autowireReturns' => [$anonymousFunction],
            ],
            [
                'routeController' => CallbackTest::class,
                'routeName' => '',
                'autoWireArguments' => [[CallbackTest::class], [[$callbackTestObj, '']]],
                'autowireReturns' => [
                    fn () => $callbackTestObj,
                    [$callbackTestObj, '__invoke'],
                ],
            ],
            [
                'routeController' => CallbackTest::class,
                'routeName' => 'hello-with-response',
                'autoWireArguments' => [[CallbackTest::class], [[$callbackTestObj, 'helloWithResponse']]],
                'autowireReturns' => [
                    fn () => $callbackTestObj,
                    [$callbackTestObj, 'helloWithResponse'],
                ],
            ],
            [
                'routeController' => [CallbackTest::class, 'helloWithResponse'],
                'routeName' => '',
                'autoWireArguments' => [[CallbackTest::class], [[$callbackTestObj, 'helloWithResponse']]],
                'autowireReturns' => [
                    fn () => $callbackTestObj,
                    [$callbackTestObj, 'helloWithResponse'],
                ],
            ],
            [
                'routeController' => CallbackTest::class.'::helloWithResponse',
                'routeName' => '',
                'autoWireArguments' => [[CallbackTest::class], [[$callbackTestObj, 'helloWithResponse']]],
                'autowireReturns' => [
                    fn () => $callbackTestObj,
                    [$callbackTestObj, 'helloWithResponse'],
                ],
            ],
            [
                'routeController' => [$callbackTestObj, 'helloWithResponse'],
                'routeName' => 'does-not-matter',
                'autoWireArguments' => [[[$callbackTestObj, 'helloWithResponse']]],
                'autowireReturn' => [
                    [$callbackTestObj, 'helloWithResponse'],
                ],
            ],
            [
                'routeController' => $callbackTestObj,
                'routeName' => '',
                'autoWireArguments' => [[$callbackTestObj]],
                'autowireReturn' => [$callbackTestObj],
            ],
            [
                'routeController' => $callbackTestObj,
                'routeName' => 'hello-with-response',
                'autoWireArguments' => [[$callbackTestObj]],
                'autowireReturn' => [$callbackTestObj],
            ],
        ];
    }

    public function testInvokeWithRouteInvalidConfigurationException(): void
    {
        $route = $this->createMock(RouteInterface::class);
        $route->expects($this->once())
            ->method('getController')
            ->willReturn([]);

        $route->expects($this->any())
            ->method('getName')
            ->willReturn('route-name');

        $autowireHelper = $this->createMock(AutowireHelperInterface::class);
        $autowireHelper->expects($this->any())
            ->method('autowire')
            ->willReturn(fn () => new Response());

        $responseCallback = new ResponseCallback(
            $autowireHelper,
            $route,
        );

        $this->expectException(RouteInvalidConfigurationException::class);
        $responseCallback();
    }
}
