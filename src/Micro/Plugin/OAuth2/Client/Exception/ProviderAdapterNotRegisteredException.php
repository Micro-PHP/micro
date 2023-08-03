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

namespace Micro\Plugin\OAuth2\Client\Exception;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class ProviderAdapterNotRegisteredException extends \RuntimeException
{
    /**
     * @param string $providerType
     * @param \Throwable|null $throwable
     */
    public function __construct(string $providerType, \Throwable $throwable = null)
    {
        parent::__construct(
            sprintf('OAuth2 provider "%s" is not registered.', $providerType),
            0,
            $throwable,
        );
    }
}