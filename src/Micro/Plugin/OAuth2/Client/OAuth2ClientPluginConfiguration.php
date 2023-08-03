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

namespace Micro\Plugin\OAuth2\Client;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\OAuth2\Client\Configuration\OAuth2ClientPluginConfigurationInterface;
use Micro\Plugin\OAuth2\Client\Configuration\Provider\OAuth2ClientProviderConfiguration;
use Micro\Plugin\OAuth2\Client\Configuration\Provider\OAuth2ClientProviderConfigurationInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class OAuth2ClientPluginConfiguration extends PluginConfiguration implements OAuth2ClientPluginConfigurationInterface
{
    /**
     * @param string $providerName
     *
     * @return OAuth2ClientProviderConfigurationInterface
     */
    public function getProviderConfiguration(string $providerName): OAuth2ClientProviderConfigurationInterface
    {
        return new OAuth2ClientProviderConfiguration($this->configuration, $providerName);
    }
}