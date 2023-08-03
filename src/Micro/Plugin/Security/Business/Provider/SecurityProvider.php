<?php

namespace Micro\Plugin\Security\Business\Provider;

use Micro\Plugin\Security\Business\Token\Decoder\DecoderFactoryInterface;
use Micro\Plugin\Security\Configuration\Provider\ProviderConfigurationInterface;
use Micro\Plugin\Security\Business\Token\Encoder\EncoderFactoryInterface;
use Micro\Plugin\Security\Token\Token;
use Micro\Plugin\Security\Token\TokenInterface;

readonly class SecurityProvider implements SecurityProviderInterface
{
    /**
     * @param EncoderFactoryInterface $encoderFactory
     * @param DecoderFactoryInterface $decoderFactory
     * @param ProviderConfigurationInterface $providerConfiguration
     */
    public function __construct(
        private EncoderFactoryInterface $encoderFactory,
        private DecoderFactoryInterface $decoderFactory,
        private ProviderConfigurationInterface $providerConfiguration,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function generateToken(array $sourceData): TokenInterface
    {
        $generatedTokenString = $this->encoderFactory
            ->create($this->providerConfiguration)
            ->encode($sourceData);

        return $this->createToken(
            $generatedTokenString,
            $sourceData
        );
    }

    /**
     * {@inheritDoc}
     */
    public function decodeToken(string $encoded): TokenInterface
    {
        $decoded = $this->decoderFactory
            ->create($this->providerConfiguration)
            ->decode($encoded);

        return $this->createToken(
            encoded: $encoded,
            tokenData: $decoded
        );
    }

    /**
     * @param string $encoded
     * @param array $tokenData
     *
     * @return Token
     */
    protected function createToken(string $encoded, array $tokenData): TokenInterface
    {
        return new Token(
            source: $encoded,
            parameters: $tokenData
        );
    }
}