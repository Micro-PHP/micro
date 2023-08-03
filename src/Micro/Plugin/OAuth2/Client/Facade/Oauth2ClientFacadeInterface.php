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

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
interface Oauth2ClientFacadeInterface
{
    /**
     * @param string $providerName
     *
     * @return AbstractProvider
     */
    public function getProvider(string $providerName): AbstractProvider;
}