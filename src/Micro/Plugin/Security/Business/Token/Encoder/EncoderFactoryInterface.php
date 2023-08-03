<?php

namespace Micro\Plugin\Security\Business\Token\Encoder;

use Micro\Plugin\Security\Configuration\Provider\ProviderConfigurationInterface;

interface EncoderFactoryInterface
{
    /**
     * @param ProviderConfigurationInterface $providerConfiguration
     *
     * @return EncoderInterface
     */
    public function create(ProviderConfigurationInterface $providerConfiguration): EncoderInterface;
}