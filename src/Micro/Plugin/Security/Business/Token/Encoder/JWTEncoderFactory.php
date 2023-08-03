<?php

namespace Micro\Plugin\Security\Business\Token\Encoder;

use Micro\Plugin\Security\Configuration\Provider\ProviderConfigurationInterface;

class JWTEncoderFactory implements EncoderFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ProviderConfigurationInterface $providerConfiguration): EncoderInterface
    {
        return new JWTEncoder(
            privateKey: $providerConfiguration->getSecretKey(),
            encryptAlgorithm: $providerConfiguration->getEncryptionAlgorithm(),
            passphrase: $providerConfiguration->getPassphrase(),
        );
    }
}