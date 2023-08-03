<?php

namespace Micro\Plugin\Security\Facade;

use Micro\Plugin\Security\Business\Provider\SecurityProviderFactoryInterface;
use Micro\Plugin\Security\Configuration\SecurityPluginConfigurationInterface;
use Micro\Plugin\Security\Token\TokenInterface;

readonly class SecurityFacade implements SecurityFacadeInterface
{
    public function __construct(
        private SecurityProviderFactoryInterface $securityProviderFactory
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function generateToken(array $parameters, string $providerName = null): TokenInterface
    {
        if(!$providerName) {
            $providerName = SecurityPluginConfigurationInterface::PROVIDER_DEFAULT;
        }

        return $this->securityProviderFactory
            ->create($providerName)
            ->generateToken($parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function decodeToken(string $encoded, string $providerName = null): TokenInterface
    {
        if(!$providerName) {
            $providerName = SecurityPluginConfigurationInterface::PROVIDER_DEFAULT;
        }

        return $this->securityProviderFactory
            ->create($providerName)
            ->decodeToken($encoded);
    }
}