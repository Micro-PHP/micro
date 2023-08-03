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

namespace Micro\Plugin\HttpLogger\Tests\Unit\Business\Logger\Formatter\Format;

use Micro\Plugin\HttpCore\Exception\HttpException;
use Micro\Plugin\HttpLogger\Business\Logger\Formatter\Format\LogFormatterConcreteInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
abstract class AbstractFormatTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testFormat(bool $hasResponse, \Throwable|null $throwable)
    {
        $object = $this->createTestObject();

        $this->assertResult(
            $object,
            $object->format(
                $this->createRequest(),
                $this->createResponse($hasResponse),
                $this->createThrowable($throwable),
                $this->getFormattedVariable()
            )
        );
    }

    protected function getAcceptedValue()
    {
        return 'hello - '.$this->getVariable();
    }

    public function dataProvider()
    {
        return [
            [false, null],
            [true, null],
            [true, new HttpException()],
            [false, new HttpException()],
            [true, new \Exception()],
            [false, new \Exception()],
        ];
    }

    protected function assertResult(mixed $object, mixed $result)
    {
        $this->assertEquals(
            $this->getAcceptedValue(),
            $result
        );
    }

    public function createThrowable(\Throwable|null $throwable): \Throwable|null
    {
        return $throwable;
    }

    protected function createResponse(bool $hasResponse): Response|null
    {
        if (!$hasResponse) {
            return null;
        }

        return $this->createMock(Response::class);
    }

    protected function createRequest(): Request
    {
        return Request::create('/test');
    }

    abstract protected function getTestClass(): string;

    protected function createTestObject(): LogFormatterConcreteInterface
    {
        $testClass = $this->getTestClass();

        return new $testClass();
    }

    protected function getFormattedVariable()
    {
        return 'hello - {{'.$this->getVariable().'}}';
    }

    abstract public function getVariable(): string;
}
