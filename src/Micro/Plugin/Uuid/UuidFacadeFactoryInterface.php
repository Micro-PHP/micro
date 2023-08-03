<?php

namespace Micro\Plugin\Uuid;

interface UuidFacadeFactoryInterface
{
    /**
     * @return UuidFacadeInterface
     */
    public function create(): UuidFacadeInterface;
}
