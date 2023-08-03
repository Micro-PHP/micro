<?php

namespace Micro\Plugin\Uuid\Business;

interface UuidGeneratorFactoryInterface
{
    /**
     * @return UuidGeneratorInterface
     */
    public function create(): UuidGeneratorInterface;
}
