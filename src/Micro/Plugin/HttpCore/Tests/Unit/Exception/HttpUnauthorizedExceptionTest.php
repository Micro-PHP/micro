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

use Micro\Plugin\HttpCore\Exception\HttpUnauthorizedException;

class HttpUnauthorizedExceptionTest extends AbstractHttpExceptionTest
{
    public function testConstruct()
    {
        $this->code = 401;
        $this->message = 'Unauthorized.';

        parent::testConstruct();

        throw new HttpUnauthorizedException();
    }
}
