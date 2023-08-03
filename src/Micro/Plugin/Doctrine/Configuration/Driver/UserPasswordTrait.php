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

trait UserPasswordTrait
{
    protected static string $CFG_IN_USER = 'ORM_%s_USER';
    protected static string $CFG_PASSWORD = 'ORM_%s_PASSWORD';

    public function getUser(): ?string
    {
        return $this->get(self::$CFG_IN_USER);
    }

    public function getPassword(): ?string
    {
        return $this->get(self::$CFG_PASSWORD);
    }
}
