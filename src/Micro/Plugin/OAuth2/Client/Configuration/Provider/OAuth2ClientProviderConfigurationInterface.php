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

namespace Micro\Plugin\OAuth2\Client\Configuration\Provider;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
interface OAuth2ClientProviderConfigurationInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getClientId(): string;

    /**
     * @return string
     */
    public function getClientSecret(): string;

    /**
     * @return string
     */
    public function getUrlRedirect(): string;

    /**
     * @return string
     */
    public function getUrlAuthorization(): string;

    /**
     * @return string
     */
    public function getUrlResourceOwnerDetails(): string;
}