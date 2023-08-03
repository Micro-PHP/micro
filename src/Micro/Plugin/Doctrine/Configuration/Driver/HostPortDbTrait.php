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

namespace Micro\Plugin\Doctrine\Configuration\Driver;

trait HostPortDbTrait
{
    protected static string $CFG_HOST = 'ORM_%s_HOST';
    protected static string $CFG_PORT = 'ORM_%s_PORT';
    protected static string $CFG_DB = 'ORM_%s_DATABASE';

    public function getHost(): ?string
    {
        return $this->get(self::$CFG_HOST, '127.0.0.1', false);
    }

    public function getPort(int|null $default = null): ?int
    {
        return (int) $this->get(self::$CFG_PORT, $default) ?: null;
    }

    public function getDb(): string
    {
        return $this->get(self::$CFG_DB, null, false);
    }
}
