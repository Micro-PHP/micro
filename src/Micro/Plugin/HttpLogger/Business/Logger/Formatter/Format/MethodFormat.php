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

namespace Micro\Plugin\HttpLogger\Business\Logger\Formatter\Format;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class MethodFormat extends AbstractFormat
{
    protected function getVarValue(Request $request, Response|null $response, ?\Throwable $exception): string
    {
        return $request->getMethod();
    }

    protected function getVarName(): string
    {
        return 'request_method';
    }
}
