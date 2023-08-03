<?php

namespace Micro\Plugin\Security\Configuration\Provider;

interface ProviderConfigurationInterface
{
    const ALGO_DEFAULT = 'HS256';
    const SECRET_DEFAULT = 'default_secret_phrase';

    /**
     * Supported algorithms are 'ES384','ES256', 'HS256', 'HS384', 'HS512', 'RS256', 'RS384', and 'RS512'
     *
     * @return string
     */
    public function getEncryptionAlgorithm(): string;

    /**
     * @return string
     */
    public function getSecretKey(): string;

    /**
     * @return string
     */
    public function getPublicKey(): string;

    /**
     * @return string|null
     */
    public function getPassphrase(): ?string;

    /**
     * @return int
     */
    public function getLifetimeDefault(): int;
}