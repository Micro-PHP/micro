<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit\Exception;

use Micro\Plugin\HttpCore\Exception\HttpException;

class HttpExceptionTest extends AbstractHttpExceptionTest
{
    public function testConstruct()
    {
        $this->code = -1;
        $this->message = 'test.';

        parent::testConstruct();

        throw new HttpException($this->message, $this->code);
    }
}
