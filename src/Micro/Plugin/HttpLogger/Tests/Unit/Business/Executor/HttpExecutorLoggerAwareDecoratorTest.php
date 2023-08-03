<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpLogger\Tests\Unit\Business\Executor;

use Micro\Plugin\HttpCore\Exception\HttpException;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Micro\Plugin\HttpLogger\Business\Executor\HttpExecutorLoggerAwareDecorator;
use Micro\Plugin\HttpLogger\Business\Logger\Formatter\LogFormatterInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpExecutorLoggerAwareDecoratorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testExecute(bool $isFlush, ?\Throwable $throwable)
    {
        $decorator = new HttpExecutorLoggerAwareDecorator(
            $this->createDecorated($throwable),
            $this->createLogger(),
            $this->createLogger(),
            $this->createFormatter(),
            $this->createFormatter()
        );

        if ($throwable) {
            $this->expectException(\get_class($throwable));
            $this->expectExceptionCode($throwable->getCode());
        }

        $this->assertInstanceOf(
            Response::class,
            $decorator->execute(
                $this->createMock(Request::class),
                $isFlush
            )
        );
    }

    public function dataProvider()
    {
        return [
            [
                true, new HttpException('Hello 500', 500),
            ],
            [
                false, new HttpException('Hello 404', 404),
            ],
            [
                true, new \Exception('Hello exception'),
            ],
            [
                false, null,
            ],
        ];
    }

    protected function createDecorated(?\Throwable $throwable)
    {
        $decorated = $this->createMock(HttpFacadeInterface::class);
        $methodMock = $decorated
            ->expects($this->once())
            ->method('execute')
        ;
        if ($throwable) {
            $methodMock->willThrowException($throwable);
        } else {
            $methodMock->willReturn(
                $this->createMock(Response::class)
            );
        }

        return $decorated;
    }

    protected function createLogger()
    {
        return $this->createMock(LoggerInterface::class);
    }

    protected function createFormatter()
    {
        return $this->createMock(LogFormatterInterface::class);
    }
}
