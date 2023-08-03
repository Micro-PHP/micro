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

use Micro\Plugin\HttpCore\Exception\HttpNotFoundException;

class HttpNotFoundExceptionTest extends AbstractHttpExceptionTest
{
    public function testConstruct()
    {
        $this->code = 404;
        $this->message = 'Not Found.';

        parent::testConstruct();

        throw new HttpNotFoundException();
    }
}
