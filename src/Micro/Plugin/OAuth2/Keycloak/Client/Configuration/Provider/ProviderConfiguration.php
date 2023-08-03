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

namespace Micro\Plugin\OAuth2\Keycloak\Client\Configuration\Provider;

use Micro\Plugin\OAuth2\Client\Configuration\Provider\OAuth2ClientProviderConfiguration;
use Micro\Plugin\OAuth2\Keycloak\Client\Provider\KeycloakProviderConfigurationInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class ProviderConfiguration extends OAuth2ClientProviderConfiguration implements KeycloakProviderConfigurationInterface
{
    const CFG_REALM = 'MICRO_OAUTH2_%s_REALM';
    const CFG_SCOPES = 'MICRO_OAUTH2_%s_SCOPES';

    /**
     * {@inheritDoc}
     */
    public function getRealm(): string
    {
        return $this->get(self::CFG_REALM, 'micro');
    }

    /**
     * {@inheritDoc}
     */
    public function getScopesDefault(): array
    {
        return $this->explodeStringToArray($this->get(self::CFG_SCOPES, 'email,profile'));
    }

    /**
     * {@inheritDoc}
     */
    public function getScopesSeparator(): string
    {
        return ' ';
    }

    public function getSecurityProvider(): string|null
    {
        return null;
    }
}