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

use Micro\Plugin\HttpLogger\Business\Logger\Formatter\LogFormatterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
interface LogFormatterConcreteInterface extends LogFormatterInterface
{
    public function format(Request $request, ?Response $response, ?\Throwable $exception, ?string $message = null): string;
}
