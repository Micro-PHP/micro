<?php

namespace Micro\Plugin\Security\Business\Provider;

use Micro\Plugin\Security\Business\Token\Decoder\DecoderFactoryInterface;
use Micro\Plugin\Security\Configuration\SecurityPluginConfigurationInterface;
use Micro\Plugin\Security\Business\Token\Encoder\EncoderFactoryInterface;

readonly class SecurityProviderFactory implements SecurityProviderFactoryInterface
{
    /**
     * @param EncoderFactoryInterface $encoderFactory
     * @param DecoderFactoryInterface $decoderFactory
     * @param SecurityPluginConfigurationInterface $securityPluginConfiguration
     */
    public function __construct(
        private EncoderFactoryInterface $encoderFactory,
        private DecoderFactoryInterface $decoderFactory,
        private SecurityPluginConfigurationInterface $securityPluginConfiguration
    )
    {
    }

    /**
     * @param string $providerName
     *
     * @return SecurityProviderInterface
     */
    public function create(string $providerName): SecurityProviderInterface
    {
        return new SecurityProvider(
            $this->encoderFactory,
            $this->decoderFactory,
            $this->securityPluginConfiguration->getProviderConfiguration($providerName)
        );
    }
}