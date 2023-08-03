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

class AuthorizationConfiguration extends PluginRoutingKeyConfiguration implements AuthorizationConfigurationInterface
{
    protected const CFG_USERNAME = 'REDIS_%s_AUTH_USERNAME';
    protected const CFG_PASSWORD = 'REDIS_%s_AUTH_PASSWORD';

    /**
     * {@inheritDoc}
     */
    public function username(): ?string
    {
        return $this->get(self::CFG_USERNAME);
    }

    /**
     * {@inheritDoc}
     */
    public function password(): ?string
    {
        return $this->get(self::CFG_PASSWORD);
    }
}
