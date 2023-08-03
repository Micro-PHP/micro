<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpLogger\Tests\Unit\Business\Logger\Formatter;

use Micro\Plugin\HttpLogger\Business\Logger\Formatter\LogFormatter;
use Micro\Plugin\HttpLogger\Business\Logger\Formatter\LogFormatterInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LogFormatterTest extends TestCase
{
    public function testFormat()
    {
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);
        $exception = $this->createMock(\Throwable::class);

        $implFormatter = $this->createMock(LogFormatterInterface::class);
        $implFormatter
            ->expects($this->once())
            ->method('format')
            ->with(
                $request,
                $response,
                $exception
            )->willReturn('test')
        ;

        $formatter = new LogFormatter(
            [$implFormatter],
            'test {{template}}'
        );

        $this->assertEquals('test', $formatter->format($request, $response, $exception));
    }
}
