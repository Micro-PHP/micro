<?php

namespace Micro\Plugin\Security\Configuration\Provider;

use Micro\Framework\BootConfiguration\Configuration\PluginRoutingKeyConfiguration;

class ProviderConfiguration extends PluginRoutingKeyConfiguration implements ProviderConfigurationInterface
{

    const CFG_PROVIDER_ENC_ALGO = 'SECURITY_TOKEN_PROVIDER_%s_ALGORITHM';
    const CFG_PROVIDER_SECRET_KEY = 'SECURITY_TOKEN_PROVIDER_%s_SECRET';
    const CFG_PROVIDER_PUB_KEY = 'SECURITY_TOKEN_PROVIDER_%s_PUBLIC';
    const CFG_PROVIDER_PASSPHRASE = 'SECURITY_TOKEN_PROVIDER_%s_PASSPHRASE';
    const CFG_PROVIDER_LIFETIME_DEFAULT = 'SECURITY_TOKEN_PROVIDER_%s_LIFETIME';

    /**
     * {@inheritDoc}
     */
    public function getEncryptionAlgorithm(): string
    {
        return $this->get(self::CFG_PROVIDER_ENC_ALGO, self::ALGO_DEFAULT);
    }

    /**
     * {@inheritDoc}
     */
    public function getSecretKey(): string
    {
        $result = $this->get(self::CFG_PROVIDER_SECRET_KEY);
        if(!$result && $this->getEncryptionAlgorithm() === self::ALGO_DEFAULT) {
            return self::SECRET_DEFAULT;
        }

        return $this->getKey($result);
    }

    /**
     * {@inheritDoc}
     */
    public function getPublicKey(): string
    {
        $result = $this->get(self::CFG_PROVIDER_PUB_KEY);
        if(!$result && $this->getEncryptionAlgorithm() === self::ALGO_DEFAULT) {
            return $this->getSecretKey();
        }

        return $this->getKey($result);
    }

    /**
     * {@inheritDoc}
     */
    public function getPassphrase(): ?string
    {
        return $this->get(self::CFG_PROVIDER_PASSPHRASE);
    }

    /**
     * TODO: Temporary solution
     *
     *
     * @param string $key
     *
     * @return string
     */
    protected function getKey(string $key): string
    {
        if(!is_file($key)) {
            return $key;
        }

        return file_get_contents($key);
    }

    /**
     * @return int
     */
    public function getLifetimeDefault(): int
    {
        return $this->get(self::CFG_PROVIDER_LIFETIME_DEFAULT, 0, false);
    }
}