<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpExceptions\Tests\Unit\Business\Executor;

use Micro\Plugin\HttpExceptions\Business\Executor\HttpExceptionExecutorDecorator;
use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorInterface;
use Micro\Plugin\HttpCore\Exception\HttpException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author ChatGPT Jan 9 Version
 */
class HttpExceptionExecutorDecoratorTest extends TestCase
{
    public function testExecute()
    {
        $decoratedMock = $this->createMock(RouteExecutorInterface::class);
        $decoratedMock->method('execute')->willReturn(new Response());

        $decorator = new HttpExceptionExecutorDecorator($decoratedMock);
        $response = $decorator->execute(new Request());
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testExecuteWithException()
    {
        $decoratedMock = $this->createMock(RouteExecutorInterface::class);
        $decoratedMock->method('execute')->willThrowException(new HttpException('test', 501));

        $decorator = new HttpExceptionExecutorDecorator($decoratedMock);
        $response = $decorator->execute(new Request());
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testExecuteWithNonHttpException()
    {
        $decoratedMock = $this->createMock(RouteExecutorInterface::class);
        $decoratedMock->method('execute')->willThrowException(new \Exception());

        $decorator = new HttpExceptionExecutorDecorator($decoratedMock);
        $response = $decorator->execute(new Request());
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testExecuteWithoutFlush()
    {
        $decoratedMock = $this->createMock(RouteExecutorInterface::class);
        $decoratedMock->method('execute')->willThrowException(new HttpException('test', 501));

        $decorator = new HttpExceptionExecutorDecorator($decoratedMock);

        $this->expectException(HttpException::class);
        $decorator->execute(new Request(), false);
    }
}
