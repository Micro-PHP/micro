<?php

namespace Micro\Plugin\Uuid\Business;

class UuidGeneratorFactory implements UuidGeneratorFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(): UuidGeneratorInterface
    {
        return new UuidGenerator();
    }
}
