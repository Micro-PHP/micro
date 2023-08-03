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

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Micro\Plugin\OAuth2\Client\Configuration\Provider\OAuth2ClientProviderConfigurationInterface;
use Micro\Plugin\Security\Facade\SecurityFacadeInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class OAuth2Provider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * @param OAuth2ClientProviderConfigurationInterface $providerConfiguration
     * @param SecurityFacadeInterface                    $securityFacade
     */
    public function __construct(
        private readonly OAuth2ClientProviderConfigurationInterface $providerConfiguration,
        private readonly SecurityFacadeInterface $securityFacade
    ) {
        parent::__construct([
            'authServerUrl' =>  $this->providerConfiguration->getUrlAuthorization(),
            'clientId'  =>      $providerConfiguration->getClientId(),
            'clientSecret'  =>  $this->providerConfiguration->getClientSecret(),
            'redirectUri'   =>  $this->providerConfiguration->getUrlRedirect(),
        ],[]);
    }

    /**
     * {@inheritDoc}
     */
    public function getBaseAuthorizationUrl(): string
    {
        return $this->getBaseUrlWithRealm() . '/protocol/openid-connect/auth';
    }

    /**
     * {@inheritDoc}
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return $this->getBaseUrlWithRealm() . '/protocol/openid-connect/token';
    }

    /**
     * {@inheritDoc}
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return $this->getBaseUrlWithRealm() . '/protocol/openid-connect/userinfo';
    }

    /**
     * @return string
     */
    protected function getBaseUrlWithRealm(): string
    {
        return
            $this->providerConfiguration->getUrlAuthorization() .
            '/realms/' .
            $this->providerConfiguration->getRealm();
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultScopes(): array
    {
        return $this->providerConfiguration->getScopesDefault();
    }

    /**
     * {@inheritDoc}
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if(is_string($data)) {
            throw new IdentityProviderException('Invalid response data', 0, $data);
        }

        if (empty($data['error'])) {
            return;
        }

        $error = $data['error'];

        if(isset($data['error_description'])){
            $error .= ': ' . $data['error_description'];
        }

        throw new IdentityProviderException($error, 0, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function getResourceOwner(AccessToken $token): ResourceOwnerInterface
    {
        $response = $this->fetchResourceOwnerDetails($token);
        if (array_key_exists('jwt', $response)) {
            $response = $response['jwt'];
        }

        $response = $this->decryptResponse($response);

        return $this->createResourceOwner($response, $token);
    }

    /**
     * Attempts to decrypt the given response.
     *
     * @param  string|array $response
     *
     * @return array|null
     */
    public function decryptResponse(string|array $response): array|null
    {
        if (!is_string($response)) {
            return $response;
        }

        return $this->securityFacade
            ->decodeToken($response)
            ->getParameters();
    }

    /**
     * {@inheritDoc}
     */
    protected function getScopeSeparator(): string
    {
        return $this->providerConfiguration->getScopesSeparator();
    }

    /**
     * {@inheritDoc}
     */
    protected function createResourceOwner(array $response, AccessToken $token): ResourceOwnerInterface
    {
        return new ResourceOwner($response);
    }
}