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

use Micro\Plugin\HttpLogger\Business\Logger\Formatter\Format\IpFormat;
use Micro\Plugin\HttpCore\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;

class IpFormatTest extends AbstractFormatTest
{
    /**
     * @dataProvider dataProvider
     */
    public function testFormat(bool $hasResponse, \Throwable|null $throwable, $hasIp = false)
    {
        $object = $this->createTestObject();

        $this->assertEquals(
            'hello - '.($hasIp ? '127.0.0.1' : ''),
            $object->format(
                $this->createRequest($hasIp),
                $this->createResponse($hasResponse),
                $this->createThrowable($throwable),
                $this->getFormattedVariable()
            )
        );
    }

    public function dataProvider()
    {
        return [
            [false, null, false],
            [true, null, false],
            [true, new HttpException(), false],
            [false, new HttpException(), false],
            [true, new \Exception(), false],
            [false, new \Exception(), false],

            [false, null, true],
            [true, null, false],
            [true, new HttpException(), true],
            [false, new HttpException(), false],
            [false, new HttpException(), true],
            [true, new \Exception(), true],
            [true, new \Exception(), false],
            [false, new \Exception(), true],
            [false, new \Exception(), false],
        ];
    }

    protected function createRequest(bool $hasIp = null): Request
    {
        if (!$hasIp) {
            return new Request();
        }

        return parent::createRequest();
    }

    protected function getTestClass(): string
    {
        return IpFormat::class;
    }

    public function getVariable(): string
    {
        return 'remote_addr';
    }
}
