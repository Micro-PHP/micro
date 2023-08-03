<?php

namespace Micro\Plugin\Security\Business\Provider;


use DomainException;
use UnexpectedValueException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Micro\Plugin\Security\Token\TokenInterface;
use InvalidArgumentException;

interface SecurityProviderInterface
{
    /**
     * @param array $sourceData
     *
     * @return TokenInterface
     */
    public function generateToken(array $sourceData): TokenInterface;

    /**
     * @param string $encoded
     *
     * @return TokenInterface
     *
     * @throws InvalidArgumentException     Provided key/key-array was empty or malformed
     * @throws DomainException              Provided JWT is malformed
     * @throws UnexpectedValueException     Provided JWT was invalid
     * @throws SignatureInvalidException    Provided JWT was invalid because the signature verification failed
     * @throws BeforeValidException         Provided JWT is trying to be used before it's eligible as defined by 'nbf'
     * @throws BeforeValidException         Provided JWT is trying to be used before it's been created as defined by 'iat'
     * @throws ExpiredException             Provided JWT has since expired, as defined by the 'exp' claim
     *
     */
    public function decodeToken(string $encoded): TokenInterface;
}