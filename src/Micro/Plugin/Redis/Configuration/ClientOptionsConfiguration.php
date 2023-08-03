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

use Micro\Framework\BootConfiguration\Configuration\PluginRoutingKeyConfiguration;

class ClientOptionsConfiguration extends PluginRoutingKeyConfiguration implements ClientOptionsConfigurationInterface
{
    public const PREFIX_DEFAULT = '';
    public const SERIALIZER_DEFAULT = ClientOptionsConfigurationInterface::SERIALIZER_NONE;
    public const SCAN_DEFAULT = '';

    protected const CFG_SERIALIZER = 'REDIS_%s_OPT_SERIALIZER';
    protected const CFG_PREFIX = 'REDIS_%s_OPT_PREFIX';
    protected const CFG_SCAN = 'REDIS_%s_OPT_SCAN';

    /**
     * {@inheritDoc}
     */
    public function serializer(): string
    {
        return $this->get(self::CFG_SERIALIZER, self::SERIALIZER_DEFAULT);
    }

    /**
     * {@inheritDoc}
     */
    public function prefix(): string
    {
        return $this->get(self::CFG_PREFIX, self::PREFIX_DEFAULT);
    }

    /**
     * {@inheritDoc}
     */
    public function scan(): string
    {
        return $this->get(self::CFG_SCAN, self::SCAN_DEFAULT);
    }
}
