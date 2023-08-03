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

namespace Micro\Plugin\OAuth2\Keycloak\Client\Provider;

use Micro\Plugin\OAuth2\Client\Configuration\Provider\OAuth2ClientProviderConfigurationInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
interface KeycloakProviderConfigurationInterface extends OAuth2ClientProviderConfigurationInterface
{
    /**
     * @return string
     */
    public function getRealm(): string;

    /**
     * @return array
     */
    public function getScopesDefault(): array;

    /**
     * @return string
     */
    public function getScopesSeparator(): string;

    /**
     * @return string|null
     */
    public function getSecurityProvider(): string|null;
}