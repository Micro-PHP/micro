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

interface SslConfigurationInterface
{
    /**
     * @return bool
     */
    public function verify(): bool;

    /**
     * @return bool
     */
    public function enabled(): bool;
}
