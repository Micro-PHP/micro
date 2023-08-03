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

namespace Micro\Plugin\OAuth2\Client\Provider\Locator;

use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\OAuth2\Client\Exception\ProviderAdapterNotRegisteredException;
use Micro\Plugin\OAuth2\Client\Provider\OAuth2ClientProviderPluginInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class ProviderPluginLocator implements ProviderPluginLocatorInterface
{
    /**
     * @param KernelInterface $kernel
     */
    public function __construct(
        private KernelInterface $kernel
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function lookup(string $providerType): OAuth2ClientProviderPluginInterface
    {
        $providerType = mb_strtolower($providerType);

        /** @var iterable<OAuth2ClientProviderPluginInterface> $iterator */
        $iterator = $this
            ->kernel
            ->plugins(OAuth2ClientProviderPluginInterface::class);

        foreach ($iterator as $providerPlugin) {
            if($providerType !== mb_strtolower($providerPlugin->getType())) {
                continue;
            }

            return $providerPlugin;
        }

        throw new ProviderAdapterNotRegisteredException($providerType);
    }
}