<?php

namespace Micro\Plugin\Security\Business\Provider;

interface SecurityProviderFactoryInterface
{
    /**
     * @param string $providerName
     *
     * @return SecurityProviderInterface
     */
    public function create(string $providerName): SecurityProviderInterface;
}