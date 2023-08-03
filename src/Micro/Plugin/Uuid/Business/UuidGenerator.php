<?php

namespace Micro\Plugin\Uuid\Business;

use Ramsey\Uuid\Uuid;

class UuidGenerator implements UuidGeneratorInterface
{
    /**
     * {@inheritDoc}
     */
    public function v1(): string
    {
        return Uuid::uuid1()->toString();
    }

    /**
     * {@inheritDoc}
     */
    public function v3(string $namespace): string
    {
        return Uuid::uuid3($this->getUuidConstant($namespace), php_uname('n'))->toString();
    }

    /**
     * {@inheritDoc}
     */
    public function v4(): string
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * {@inheritDoc}
     */
    public function v5(string $namespace): string
    {
        return Uuid::uuid5($this->getUuidConstant($namespace), php_uname('n'))->toString();
    }

    public function v6(): string
    {
        return Uuid::uuid6()->toString();
    }

    /**
     * @param string $constName
     *
     * @return mixed
     */
    protected function getUuidConstant(string $constName): string
    {
        return constant(Uuid::class . "::" . $constName);
    }
}
