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

namespace Micro\Plugin\Cache\Configuration\Adapter;

interface CachePoolConfigurationInterface
{
    public function getAdapterType(): string;

    public function getDefaultLifetime(): int;

    public function getVersion(): string|null;

    public function getNamespace(): string;

    public function getDirectory(): string|null;

    public function getConnectionName(): string;

    public function isStoreSerialized(): bool;

    public function getMaxItems(): int;
}
