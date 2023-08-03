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

use Micro\Plugin\HttpLogger\Business\Logger\Formatter\Format\UsernameFormat;

class UsernameFormatTest extends AbstractFormatTest
{
    protected function getTestClass(): string
    {
        return UsernameFormat::class;
    }

    public function getVariable(): string
    {
        return 'remote_user';
    }

    public function assertResult(mixed $object, mixed $result)
    {
        $this->assertEquals('hello - ', $result);
    }
}
