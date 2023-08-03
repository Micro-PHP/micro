<?php

declare(strict_types=1);

/**
 * This file is part of the Micro framework package.
 *
 * (c) Stanislau Komar <head.trackingsoft@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Micro\Plugin\OAuth2\Client\Facade;

use League\OAuth2\Client\Provider\AbstractProvider;
use Micro\Plugin\OAuth2\Client\Configuration\OAuth2ClientPluginConfigurationInterface;
use Micro\Plugin\OAuth2\Client\Provider\Locator\ProviderPluginLocatorFactoryInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class Oauth2ClientFacade implements Oauth2ClientFacadeInterface
{
    /**
     * @var array<string, AbstractProvider>
     */
    private array $providers = [];

    /**
     * @param ProviderPluginLocatorFactoryInterface         $providerPluginLocatorFactory
     * @param OAuth2ClientPluginConfigurationInterface      $pluginConfiguration
     */
    public function __construct(
        private readonly ProviderPluginLocatorFactoryInterface    $providerPluginLocatorFactory,
        private readonly OAuth2ClientPluginConfigurationInterface $pluginConfiguration
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getProvider(string $providerName): AbstractProvider
    {
        if(array_key_exists($providerName, $this->providers)) {
            return $this->providers[$providerName];
        }

        $providerConfig = $this->pluginConfiguration->getProviderConfiguration($providerName);
        $provider = $this->providerPluginLocatorFactory
            ->create()
            ->lookup($providerConfig->getType())
            ->createProvider($providerName);

        $this->providers[$providerName] = $provider;

        return $provider;
    }
}