<?php

namespace Micro\Plugin\Security\Facade;

use Firebase\JWT\ExpiredException;
use Micro\Plugin\Security\Token\TokenInterface;

interface SecurityFacadeInterface
{
    /**
     * @param array $parameters
     * @param string|null $providerName
     *
     * @return TokenInterface
     */
    public function generateToken(array $parameters, string $providerName = null): TokenInterface;

    /**
     * @param string $encoded
     * @param string|null $providerName
     *
     * @return TokenInterface
     *
     * @throws ExpiredException
     */
    public function decodeToken(string $encoded, string $providerName = null): TokenInterface;
}