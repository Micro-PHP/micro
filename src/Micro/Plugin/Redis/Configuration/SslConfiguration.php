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

class SslConfiguration extends PluginRoutingKeyConfiguration implements SslConfigurationInterface
{
    public const SSL_ENABLED_DEFAULT = false;
    public const SSL_VERIFY_DEFAULT = false;

    protected const CFG_SSL_ENABLED = 'REDIS_%s_SSL_ENABLED';
    protected const CFG_SSL_VERIFY = 'REDIS_%s_SSL_VERIFY';

    /**
     * @return bool
     */
    public function verify(): bool
    {
        return $this->get(self::CFG_SSL_VERIFY, self::SSL_VERIFY_DEFAULT);
    }

    /**
     * @return bool
     */
    public function enabled(): bool
    {
        return $this->get(self::CFG_SSL_ENABLED, self::SSL_ENABLED_DEFAULT);
    }
}
