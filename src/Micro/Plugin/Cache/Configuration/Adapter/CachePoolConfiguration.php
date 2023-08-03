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

use Micro\Framework\BootConfiguration\Configuration\PluginRoutingKeyConfiguration;

class CachePoolConfiguration extends PluginRoutingKeyConfiguration implements CachePoolConfigurationInterface
{
    public const CFG_ADAPTER_TYPE = 'MICRO_CACHE_%s_TYPE';

    public const CFG_ADAPTER_TTL = 'MICRO_CACHE_%s_DEFAULT_TTL';

    public const CFG_ADAPTER_VERSION = 'MICRO_CACHE_%s_VERSION';

    public const CFG_ADAPTER_NAMESPACE = 'MICRO_CACHE_%s_NAMESPACE';

    public const CFG_ADAPTER_DIR = 'MICRO_CACHE_%s_DIR';

    public const CFG_ADAPTER_CONNECTION = 'MICRO_CACHE_%s_CONNECTION';

    public const CFG_ADAPTER_STORE_SERIALIZED = 'MICRO_CACHE_%s_STORE_SERIALIZED';

    public const CFG_MAX_ITEMS = 'MICRO_CACHE_%s_MSX_ITEMS';

    public function getAdapterType(): string
    {
        return mb_strtolower($this->get(self::CFG_ADAPTER_TYPE, null, false));
    }

    public function getDefaultLifetime(): int
    {
        return (int) $this->get(self::CFG_ADAPTER_TTL, 0, false);
    }

    public function getVersion(): string|null
    {
        return (string) $this->get(self::CFG_ADAPTER_VERSION);
    }

    public function getNamespace(): string
    {
        return (string) $this->get(self::CFG_ADAPTER_NAMESPACE, '');
    }

    public function getDirectory(): string|null
    {
        return $this->get(self::CFG_ADAPTER_DIR);
    }

    public function getConnectionName(): string
    {
        return $this->get(self::CFG_ADAPTER_CONNECTION, null, false);
    }

    public function isStoreSerialized(): bool
    {
        return (bool) $this->get(self::CFG_ADAPTER_STORE_SERIALIZED, true, false);
    }

    public function getMaxItems(): int
    {
        return (int) $this->get(self::CFG_MAX_ITEMS, 0, false);
    }
}
