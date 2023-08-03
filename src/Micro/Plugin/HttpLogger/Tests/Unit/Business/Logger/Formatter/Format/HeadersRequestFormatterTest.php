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

use Micro\Plugin\HttpLogger\Business\Logger\Formatter\Format\HeadersRequestFormatter;
use Micro\Plugin\HttpLogger\Business\Logger\Formatter\Format\LogFormatterConcreteInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HeadersRequestFormatterTest extends TestCase
{
    private LogFormatterConcreteInterface $testObject;

    protected function setUp(): void
    {
        $this->testObject = new HeadersRequestFormatter([
            'AuThorizAtioN',
        ]);
    }

    protected function createRequest(): Request
    {
        $request = new Request();

        $request->headers->set('test-1', 'Stas');
        $request->headers->set('test-2', 'Komar');
        $request->headers->set('authorization', 'my secret token key');

        return $request;
    }

    protected function createResponse(bool $noResponse): ?Response
    {
        return $noResponse ? null : new Response();
    }

    protected function createException(bool $noException)
    {
        return $noException ? null : new \Exception();
    }

    public function testFormat()
    {
        $messageTemplate = 'Hello, {{request_header.test-1}} and {{request_header.test-2}} and null{{request_header.test-null}} {{should_be_not_formatted}}';
        $messageAccepted = 'Hello, Stas and Komar and null {{should_be_not_formatted}}';

        $formatted = $this->testObject->format(
            $this->createRequest(),
            $this->createResponse(true),
            $this->createException(true),
            $messageTemplate
        );

        $this->assertEquals($messageAccepted, $formatted);
    }

    public function testHeadersAllFormat()
    {
        $messageTemplate = 'Hello, {{should_be_not_formatted}} {{request_header.*}}';
        $messageAccepted = 'Hello, {{should_be_not_formatted}} {"test-1":["Stas"],"test-2":["Komar"],"authorization":["** Secured **"]}';

        $formatted = $this->testObject->format(
            $this->createRequest(),
            $this->createResponse(true),
            $this->createException(true),
            $messageTemplate
        );

        $this->assertEquals($messageAccepted, $formatted);
    }

    public function testHeadersEmptyHeaderVarFormat()
    {
        $messageTemplate = 'Hello, {{should_be_not_formatted}} {{request_header.}}';
        $messageAccepted = 'Hello, {{should_be_not_formatted}} ';

        $formatted = $this->testObject->format(
            $this->createRequest(),
            $this->createResponse(true),
            $this->createException(true),
            $messageTemplate
        );

        $this->assertEquals($messageAccepted, $formatted);
    }
}
