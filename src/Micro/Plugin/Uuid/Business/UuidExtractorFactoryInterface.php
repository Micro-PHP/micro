<?php

namespace Micro\Plugin\Uuid\Business;

interface UuidExtractorFactoryInterface
{
    /**
     * @return UuidExtractorInterface
     */
    public function create(): UuidExtractorInterface;
}
