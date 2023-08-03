<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit\Business\Executor;

use Micro\Framework\DependencyInjection\ContainerRegistryInterface;
use Micro\Plugin\HttpCore\Business\Executor\RouteExecutor;
use Micro\Plugin\HttpCore\Business\Matcher\UrlMatcherInterface;
use Micro\Plugin\HttpCore\Business\Response\Callback\ResponseCallbackFactoryInterface;
use Micro\Plugin\HttpCore\Business\Response\Callback\ResponseCallbackInterface;
use Micro\Plugin\HttpCore\Business\Response\Transformer\ResponseTransformerFactoryInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use Micro\Plugin\HttpCore\Exception\HttpException;
use Micro\Plugin\HttpCore\Exception\ResponseInvalidException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteExecutorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testExecute(bool $isFlush, \Throwable|null $exception)
    {
        $containerRegistry = $this->createMock(ContainerRegistryInterface::class);
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);
        $responseTransformerFactory = $this->createMock(ResponseTransformerFactoryInterface::class);

        if ($isFlush && !$exception) {
            $response
                ->expects($this->once())
                ->method('send');
        }

        $executor = new RouteExecutor(
            $this->createUrlMatcher($request),
            $containerRegistry,
            $this->createResponseCallbackFactory($response, $exception),
            $responseTransformerFactory
        );

        if ($exception) {
            $this->expectException(HttpException::class);
        }

        $response = $executor->execute($request);
        $this->assertInstanceOf(Response::class, $response);
    }

    public static function dataProvider(): array
    {
        return [
            [true, null],
            [false, new HttpException()],
            [false, new ResponseInvalidException('Response invalid exception data')],
            [false, new \Exception('Simple exception')],
        ];
    }

    protected function createResponseCallbackFactory(Response $response, \Throwable|null $throwExceptionInCallback): ResponseCallbackFactoryInterface
    {
        $responseCallbackFactory = $this->createMock(ResponseCallbackFactoryInterface::class);
        $responseCallbackFactory
            ->expects($this->once())
            ->method('create')
            ->withAnyParameters()
            ->willReturn(
                new class($throwExceptionInCallback, $response) implements ResponseCallbackInterface {
                    public function __construct(
                        private readonly \Throwable|null $throwExceptionInCallback,
                        private readonly Response $response
                    ) {
                    }

                    public function __invoke(): Response
                    {
                        if ($this->throwExceptionInCallback) {
                            throw $this->throwExceptionInCallback;
                        }

                        return $this->response;
                    }
                }
            );

        return $responseCallbackFactory;
    }

    protected function createUrlMatcher(Request $request): UrlMatcherInterface
    {
        $route = $this->createMock(RouteInterface::class);
        $urlMatcher = $this->createMock(UrlMatcherInterface::class);
        $urlMatcher
            ->expects($this->once())
            ->method('match')
            ->with($request)
            ->willReturn($route)
        ;

        return $urlMatcher;
    }
}
