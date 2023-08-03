<?php

namespace Micro\Plugin\Security\Business\Token\Decoder;

use Micro\Plugin\Security\Configuration\Provider\ProviderConfigurationInterface;

class JWTDecoderFactory implements DecoderFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ProviderConfigurationInterface $providerConfiguration): DecoderInterface
    {
        return new JWTDecoder(
            publicKey: $providerConfiguration->getPublicKey(),
            encryptAlgorithm: $providerConfiguration->getEncryptionAlgorithm()
        );
    }
}