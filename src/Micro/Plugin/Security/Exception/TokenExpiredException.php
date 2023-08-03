<?php

namespace Micro\Plugin\Security\Exception;

class TokenExpiredException extends SecurityException
{
    public function __construct(string $token, \Throwable $throwable = null) {
        parent::__construct(sprintf('Token "%s" was expired.', $token), 0, $throwable);
    }
}