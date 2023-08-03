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

namespace Micro\Plugin\Filesystem\Configuration\Adapter;

use Micro\Framework\BootConfiguration\Configuration\PluginRoutingKeyConfiguration;

class AbstractFilesystemAdapterConfiguration extends PluginRoutingKeyConfiguration implements FilesystemAdapterConfigurationInterface
{
    public const CFG_ADAPTER_TYPE = 'MICRO_FS_%s_PUBLIC_URL';

    /**
     * {@inheritDoc}
     */
    public function getPublicUrl(): null|string
    {
        return (string) $this->get(self::CFG_ADAPTER_TYPE);
    }
}
