<?php

namespace Micro\Plugin\Security\Business\Token\Decoder;

use Micro\Plugin\Security\Configuration\Provider\ProviderConfigurationInterface;

interface DecoderFactoryInterface
{
    /**
     * @param ProviderConfigurationInterface $providerConfiguration
     *
     * @return DecoderInterface
     */
    public function create(ProviderConfigurationInterface $providerConfiguration): DecoderInterface;
}