<?php

namespace Micro\Plugin\Security\Business\Token\Decoder;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

readonly class JWTDecoder implements DecoderInterface
{
    /**
     * @param string $publicKey
     * @param string $encryptAlgorithm
     */
    public function __construct(
        private string $publicKey,
        private string $encryptAlgorithm
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function decode(string $encodedToken): array
    {
        return (array) JWT::decode($encodedToken, new Key($this->publicKey, $this->encryptAlgorithm));
    }
}