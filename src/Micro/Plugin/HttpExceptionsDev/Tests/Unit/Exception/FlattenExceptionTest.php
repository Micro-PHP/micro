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

namespace Micro\Plugin\HttpExceptionsDev\Tests\Unit\Exception;

use Micro\Plugin\HttpExceptionsDev\Exception\FlattenException;
use PHPUnit\Framework\TestCase;

class FlattenExceptionTest extends TestCase
{
    private FlattenException $flattenException;

    protected function setUp(): void
    {
        $this->flattenException = new FlattenException();
    }

    public function testSetMessage()
    {
        $exception = new FlattenException();
        $exception->setMessage("MyClass@anonymous\x00randomtext.php0x123abc");
        $this->assertEquals('4d79436c61737340616e6f6e796d6f75730072616e646f6d746578742e7068703078313233616263', bin2hex($exception->getMessage()));

        $exception->setMessage('simple message');
        $this->assertEquals('simple message', $exception->getMessage());
    }

    public function testGetTrace()
    {
        $exception = new FlattenException();
        $exception->setTrace(debug_backtrace(), __FILE__, __LINE__);
        $trace = $exception->getTrace();

        $this->assertIsArray($trace);
        $this->assertArrayHasKey('file', $trace[0]);
        $this->assertArrayHasKey('line', $trace[0]);
        $this->assertArrayHasKey('function', $trace[0]);
    }

    public function testSetTrace()
    {
        $exception = new FlattenException();
        $exception->setTrace(debug_backtrace(), __FILE__, __LINE__);
        $trace = $exception->getTrace();

        $this->assertIsArray($trace);
        $this->assertArrayHasKey('file', $trace[0]);
        $this->assertArrayHasKey('line', $trace[0]);
        $this->assertArrayHasKey('function', $trace[0]);
    }

    private function createNestedArgArray(int $depth, int $itemsOnLevel, array $array = [], int $realDepth = 0): array
    {
        if (0 == $depth) {
            return $array;
        }

        $array["$realDepth"] = $this->createNestedArgArray($depth - 1, $itemsOnLevel, $array, ++$realDepth);
        for ($i = 0; $i < $itemsOnLevel; ++$i) {
            $array['tl_'.$realDepth.'_i_'.$i] = 'Val';
            $array['tl_'.$realDepth.'_i_'.$i] = (float) $i;
        }

        return $array;
    }

    public function testSetALotOfArgsTrace()
    {
        $exception = new FlattenException();

        $args = $this->createNestedArgArray(10, 1000);

        $trace = [
            'namespace' => '',
            'short_class' => '',
            'class' => '',
            'type' => '',
            'function' => '',
            'file' => __FILE__,
            'line' => __LINE__,
            'args' => $args,
        ];

        $exception->setTrace([$trace], __FILE__, __LINE__);
        $trace = $exception->getTrace();

        $this->assertEquals([
            'array',
            '*SKIPPED over 10000 entries*',
        ], $trace[1]['args']);
    }

    public function testDeepNestedArray()
    {
        $exception = new FlattenException();

        $level = 12;
        $args = $this->createNestedArgArray($level, 1);

        $trace = [
            'namespace' => '',
            'short_class' => '',
            'class' => '',
            'type' => '',
            'function' => '',
            'file' => __FILE__,
            'line' => __LINE__,
            'args' => $args,
        ];

        $exception->setTrace([$trace], __FILE__, __LINE__);
        $trace = $exception->getTrace();

        $tmp = $trace[1]['args'];

        for ($i = 0; $i < $level; ++$i) {
            $tmp = $tmp["$i"];
            $tmp = $tmp[1];
        }

        $this->assertEquals('*DEEP NESTED ARRAY*', $tmp);
    }

    public function testArgIsResource()
    {
        $exception = new FlattenException();

        $resource = fopen(__FILE__, 'r');

        $args = [
            'file' => $resource,
        ];

        $trace = [
            'namespace' => '',
            'short_class' => '',
            'class' => '',
            'type' => '',
            'function' => '',
            'file' => __FILE__,
            'line' => __LINE__,
            'args' => $args,
        ];

        $exception->setTrace([$trace], __FILE__, __LINE__);
        $trace = $exception->getTrace();

        @fclose($resource);

        $this->assertEquals([
            'resource',
            'stream',
        ], $trace[1]['args']['file']);
    }

    public function testAsString()
    {
        $exception = FlattenException::createFromThrowable(new \Exception('Hello', 0, new \RuntimeException('Nested')));

        $exception->setAsString(null);
        $excString = $exception->getAsString();
        $this->assertStringContainsString('Exception: Hello in', $excString);
        $this->assertStringContainsString('Stack trace:', $excString);
        $this->assertStringContainsString('Exception: Nested in', $excString);

        $exception->setAsString('hello');
        $this->assertEquals('hello', $exception->getAsString());
    }

    public function testStatusCodeAndText()
    {
        $exception = FlattenException::createFromThrowable(new \Exception('Hello', 0, new \RuntimeException('Nested')));

        $this->assertEquals('Whoops, looks like something went wrong.', $exception->getStatusText());
        $this->assertEquals('0', $exception->getStatusCode());
    }

    public function testGetHeaders()
    {
        $testedHeaders = ['content-type' => 'json'];
        $exception = FlattenException::createFromThrowable(
            new \Exception('Hello'), $testedHeaders);

        $this->assertEquals($testedHeaders, $exception->getHeaders());
    }

    public function testCreate()
    {
        $exception = FlattenException::create(new \Exception('Hello'));

        $this->assertInstanceOf(FlattenException::class, $exception);
    }
}
