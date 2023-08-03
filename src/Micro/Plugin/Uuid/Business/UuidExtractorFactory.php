<?php

namespace Micro\Plugin\Uuid\Business;

class UuidExtractorFactory implements UuidExtractorFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(): UuidExtractorInterface
    {
        return new UuidExtractor();
    }
}
