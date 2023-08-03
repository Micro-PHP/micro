<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpLogger\Tests\Unit\Business\Logger\Formatter\Format;

use Micro\Plugin\HttpLogger\Business\Logger\Formatter\Format\RequestBodyFormat;
use Symfony\Component\HttpFoundation\Request;

class RequestBodyFormatTest extends AbstractFormatTest
{
    /**
     * @dataProvider dataProvider
     */
    public function testFormat(bool $hasResponse, \Throwable|null $throwable, string|null $contentType = null)
    {
        $object = $this->createTestObject();

        $this->assertIsString(
            $object->format(
                $this->createRequest($contentType),
                $this->createResponse($hasResponse),
                $this->createThrowable($throwable),
                $this->getFormattedVariable()
            )
        );
    }

    protected function getTestClass(): string
    {
        return RequestBodyFormat::class;
    }

    public function getVariable(): string
    {
        return 'request_body';
    }

    protected function createRequest(string $contentType = null): Request
    {
        if (null === $contentType) {
            return parent::createRequest();
        }

        $request = Request::create('/test');
        $request->headers->set('Content-Type', $contentType);

        return $request;
    }

    public function dataProvider()
    {
        return [
            [true, null, 'application/EDI-X12'],
            [true, null, 'application/javascript'],
            [true, null, 'application/EDIFACT'],
            [true, null, 'application/xhtml+xml'],
            [true, null, 'application/zip'],
            [true, null, 'application/x-shockwave-flash'],
            [true, null, 'application/pdf'],
            [true, null, 'application/ogg'],
            [true, null, 'audio/mpeg'],
            [true, null, 'audio/x-ms-wma'],
            [true, null, 'audio/vnd.rn-realaudio'],
            [true, null, 'audio/x-wav'],
            [true, null, 'application/vnd.oasis.opendocument.text'],
            [true, null, 'application/vnd.oasis.opendocument.spreadsheet'],
            [true, null, 'application/vnd.oasis.opendocument.presentation'],
            [true, null, 'application/vnd.oasis.opendocument.graphics'],
            [true, null, 'application/vnd.ms-excel'],
            [true, null, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
            [true, null, 'application/vnd.ms-powerpoint'],
            [true, null, 'application/vnd.openxmlformats-officedocument.presentationml.presentation'],
            [true, null, 'application/msword'],
            [true, null, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            [true, null, 'application/vnd.mozilla.xul+xml'],
            [true, null, 'video/mpeg'],
            [true, null, 'video/mp4'],
            [true, null, 'video/quicktime'],
            [true, null, 'video/x-ms-wmv'],
            [true, null, 'video/x-msvideo'],
            [true, null, 'video/x-flv'],
            [true, null, 'video/webm'],
            [true, null, 'multipart/form-data'],
            [true, null, 'multipart/mixed'],
            [true, null, 'multipart/alternative'],
            [true, null, 'multipart/related'],
            [true, null, 'undefined'],
        ];
    }
}
