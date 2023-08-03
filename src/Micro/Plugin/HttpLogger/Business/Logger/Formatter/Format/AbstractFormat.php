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
 *
 * @codeCoverageIgnore
 */
abstract class AbstractFormat implements LogFormatterConcreteInterface
{
    public function format(Request $request, Response|null $response, ?\Throwable $exception, ?string $message = null): string
    {
        if (!$message) {
            return '';
        }

        $var = '{{'.$this->getVarName().'}}';

        if (!str_contains($message, $var)) {
            return $message;
        }

        return str_ireplace(
            $var,
            $this->getVarValue($request, $response, $exception),
            $message
        );
    }

    abstract protected function getVarValue(Request $request, Response|null $response, ?\Throwable $exception): string;

    abstract protected function getVarName(): string;
}
