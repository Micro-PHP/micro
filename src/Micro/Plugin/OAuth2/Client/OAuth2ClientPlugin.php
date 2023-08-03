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

namespace Micro\Plugin\OAuth2\Client;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Plugin\OAuth2\Client\Configuration\OAuth2ClientPluginConfigurationInterface;
use Micro\Plugin\OAuth2\Client\Facade\Oauth2ClientFacade;
use Micro\Plugin\OAuth2\Client\Facade\Oauth2ClientFacadeInterface;
use Micro\Plugin\OAuth2\Client\Provider\Locator\ProviderPluginLocatorFactory;
use Micro\Plugin\OAuth2\Client\Provider\Locator\ProviderPluginLocatorFactoryInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 *
 * @method OAuth2ClientPluginConfigurationInterface configuration()
 */
class OAuth2ClientPlugin implements DependencyProviderInterface, ConfigurableInterface
{
    use PluginConfigurationTrait;

    /**
     * @var KernelInterface
     */
    private readonly KernelInterface $kernel;

    /**
     * {@inheritDoc}
     */
    public function provideDependencies(Container $container): void
    {
        $container->register(Oauth2ClientFacadeInterface::class, function (
            KernelInterface $kernel
        ) {
            $this->kernel = $kernel;

            return $this->createFacade();
        });
    }

    /**
     * @return Oauth2ClientFacadeInterface
     */
    protected function createFacade(): Oauth2ClientFacadeInterface
    {
        return new Oauth2ClientFacade(
            $this->createProviderPluginLocatorFactory(),
            $this->configuration()
        );
    }

    /**
     * @return ProviderPluginLocatorFactoryInterface
     */
    protected function createProviderPluginLocatorFactory(): ProviderPluginLocatorFactoryInterface
    {
        return new ProviderPluginLocatorFactory($this->kernel);
    }
}