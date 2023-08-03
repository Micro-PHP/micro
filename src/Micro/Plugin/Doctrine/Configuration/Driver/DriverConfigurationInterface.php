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

/**
 * TODO: implements replication.
 */
interface DriverConfigurationInterface
{
    /**
     * @return array<string, mixed>
     */
    public function getParameters(): array;

    public static function name(): string;
}
