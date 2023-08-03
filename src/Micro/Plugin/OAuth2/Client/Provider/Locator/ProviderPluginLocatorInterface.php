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

use Micro\Plugin\OAuth2\Client\Exception\ProviderAdapterNotRegisteredException;
use Micro\Plugin\OAuth2\Client\Provider\OAuth2ClientProviderPluginInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
interface ProviderPluginLocatorInterface
{
    /**
     * @param string $providerType
     *
     * @return OAuth2ClientProviderPluginInterface
     *
     * @throws ProviderAdapterNotRegisteredException
     */
    public function lookup(string $providerType): OAuth2ClientProviderPluginInterface;
}