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

namespace Micro\Plugin\HttpLogger;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
interface HttpLoggerPluginConfigurationInterface
{
    public function getAccessLoggerName(): string;

    public function getErrorLoggerName(): string;

    public function getErrorLogFormat(): string;

    public function getAccessLogFormat(): string;

    /**
     * @return string[]
     */
    public function getRequestHeadersSecuredList(): array;

    public function getWeight(): int;
}
