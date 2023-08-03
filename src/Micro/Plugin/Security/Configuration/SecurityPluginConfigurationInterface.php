<?php

namespace Micro\Plugin\Security\Configuration;

use Micro\Plugin\Security\Configuration\Provider\ProviderConfigurationInterface;

interface SecurityPluginConfigurationInterface
{

    const PROVIDER_DEFAULT = 'default';

    /**
     * @param string $providerName
     *
     * @return ProviderConfigurationInterface
     */
    public function getProviderConfiguration(string $providerName = self::PROVIDER_DEFAULT): ProviderConfigurationInterface;
}