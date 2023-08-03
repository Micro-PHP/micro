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

use Micro\Plugin\HttpCore\Exception\HttpForbiddenException;

class HttpForbiddenExceptionTest extends AbstractHttpExceptionTest
{
    public function testConstruct()
    {
        $this->code = 403;
        $this->message = 'Forbidden.';

        parent::testConstruct();

        throw new HttpForbiddenException();
    }
}
