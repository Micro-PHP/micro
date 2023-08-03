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

namespace Micro\Plugin\OAuth2\Keycloak\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class ResourceOwner implements ResourceOwnerInterface
{
    /**
     * Creates new resource owner.
     *
     * @param array $response Raw response
     */
    public function __construct(protected array $response = [])
    {
    }

    /**
     * Get resource owner id
     *
     * @return string|null
     */
    public function getId(): string|null
    {
        return $this->getTokenParameter('sub');
    }

    /**
     * Get resource owner email
     *
     * @return string|null
     */
    public function getEmail(): string|null
    {
        return $this->getTokenParameter('email');
    }

    /**
     * Get resource owner name
     *
     * @return string|null
     */
    public function getName(): string|null
    {
        return $this->getTokenParameter('name');
    }

    /**
     * @param string $parameter
     *
     * @return string|null
     */
    protected function getTokenParameter(string $parameter): string|null
    {
        return \array_key_exists($parameter, $this->response) ? $this->response[$parameter] : null;
    }

    /**
     * Return all the owner details available as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->response;
    }
}