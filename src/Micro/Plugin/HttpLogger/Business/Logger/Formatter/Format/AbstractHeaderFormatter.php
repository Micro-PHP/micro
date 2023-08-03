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
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 *
 * @codeCoverageIgnore
 */
abstract class AbstractHeaderFormatter implements LogFormatterConcreteInterface
{
    public function format(Request $request, ?Response $response, ?\Throwable $exception, ?string $message = null): string
    {
        if (!$message) {
            return '';
        }

        $matchPattern = sprintf('/{{%s_header\.(.*?)}}/', $this->getPrefix());
        $matched = preg_match_all($matchPattern, $message, $matches);
        if (!$matched || 2 !== \count($matches)) {
            return $message;
        }

        $matchesPattern = $matches[0];
        $matchesVars = $matches[1];

        $countMatches = \count($matchesVars);

        for ($i = 0; $i < $countMatches; ++$i) {
            $message = str_ireplace(
                $matchesPattern[$i],
                $this->getValue($request, $response, $matchesVars[$i]),
                $message
            );
        }

        return $message;
    }

    abstract protected function getValue(Request $request, ?Response $response, string $matchedVar): string;

    abstract protected function getPrefix(): string;
}
