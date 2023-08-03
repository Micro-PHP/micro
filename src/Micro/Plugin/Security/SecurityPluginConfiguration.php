<?php

namespace Micro\Plugin\Security;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\Security\Configuration\Provider\ProviderConfiguration;
use Micro\Plugin\Security\Configuration\Provider\ProviderConfigurationInterface;
use Micro\Plugin\Security\Configuration\SecurityPluginConfigurationInterface;

class SecurityPluginConfiguration extends PluginConfiguration implements SecurityPluginConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getProviderConfiguration(string $providerName = self::PROVIDER_DEFAULT): ProviderConfigurationInterface
    {
        return new ProviderConfiguration($this->configuration, $providerName);
    }
}