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

namespace Micro\Plugin\Redis\Configuration;

interface ClientOptionsConfigurationInterface
{
    public const SERIALIZER_NONE = 'SERIALIZER_NONE';
    public const SERIALIZER_PHP = 'SERIALIZER_PHP';
    public const SERIALIZER_IGBINARY = 'SERIALIZER_IGBINARY';
    public const SERIALIZER_MSGPACK = 'SERIALIZER_MSGPACK';
    public const SERIALIZER_JSON = 'SERIALIZER_JSON';

    public const SCAN_NORETRY = 'SCAN_NORETRY';
    public const SCAN_RETRY = 'SCAN_RETRY';
    public const SCAN_PREFIX = 'SCAN_PREFIX';
    public const SCAN_NOPREFIX = 'SCAN_NOPREFIX';

    /**
     * @return string
     */
    public function serializer(): string;

    /**
     * @return string
     */
    public function prefix(): string;

    /**
     * @return string
     */
    public function scan(): string;
}
