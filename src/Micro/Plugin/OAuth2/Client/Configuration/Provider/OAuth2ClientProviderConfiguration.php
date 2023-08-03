<?php

declare(strict_types=1);

/**
 * This file is part of the Micro framework package.
 *
 * (c) Stanislau Komar <head.trackingsoft@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Micro\Plugin\OAuth2\Client\Configuration\Provider;

use Micro\Framework\BootConfiguration\Configuration\PluginRoutingKeyConfiguration;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class OAuth2ClientProviderConfiguration extends PluginRoutingKeyConfiguration implements OAuth2ClientProviderConfigurationInterface
{
    const CFG_TYPE                  = 'MICRO_OAUTH2_%s_TYPE';
    const CFG_CLIENT_ID             = 'MICRO_OAUTH2_%s_CLIENT_ID';
    const CFG_CLIENT_SECRET         = 'MICRO_OAUTH2_%s_CLIENT_SECRET';
    const CFG_URL_AUTHORIZATION     = 'MICRO_OAUTH2_%s_CLIENT_URL_AUTHORIZATION';
    const CFG_URL_REDIRECT          = 'MICRO_OAUTH2_%s_CLIENT_URL_REDIRECT';
    const CFG_URL_RESOURCE_OWNER    = 'MICRO_OAUTH2_%s_CLIENT_URL_RESOURCE_OWNER';

    /**
     * {@inheritDoc}
     */
    final public function getType(): string
    {
        return $this->get(self::CFG_TYPE);
    }

    /**
     * {@inheritDoc}
     */
    final public function getClientId(): string
    {
        return $this->get(self::CFG_CLIENT_ID);
    }

    /**
     * {@inheritDoc}
     */
    final public function getClientSecret(): string
    {
        return $this->get(self::CFG_CLIENT_SECRET);
    }

    /**
     * {@inheritDoc}
     */
    public function getUrlRedirect(): string
    {
        return rtrim($this->get(self::CFG_URL_REDIRECT), '/');
    }

    /**
     * {@inheritDoc}
     */
    public function getUrlAuthorization(): string
    {
        return  rtrim($this->get(self::CFG_URL_AUTHORIZATION), '/');
    }

    /**
     * {@inheritDoc}
     */
    public function getUrlResourceOwnerDetails(): string
    {
        return rtrim($this->get(self::CFG_URL_RESOURCE_OWNER), '/');
    }
}