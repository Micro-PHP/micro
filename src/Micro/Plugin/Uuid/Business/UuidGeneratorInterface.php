<?php

namespace Micro\Plugin\Uuid\Business;

interface UuidGeneratorInterface
{
    public const NAMESPACE_DNS  = 'NAMESPACE_DNS';
    public const NAMESPACE_URL  = 'NAMESPACE_URL';
    public const NAMESPACE_OID  = 'NAMESPACE_OID';
    public const NAMESPACE_X500 = 'NAMESPACE_X500';

    /**
     * This generates a Version 1: Time-based UUID.
     *
     * @return string
     */
    public function v1(): string;

    /**
     * This generates a Version 3: Name-based (MD5) UUID.
     *
     * @param string $namespace
     *
     * @return string
     */
    public function v3(string $namespace): string;

    /**
     *
     * This generates a Version 4: Random UUID.
     *
     * @return string
     */
    public function v4(): string;

    /**
     * This generates a Version 5: Name-based (SHA-1) UUID.
     *
     * @param string $namespace
     *
     * @return string
     */
    public function v5(string $namespace): string;
}
