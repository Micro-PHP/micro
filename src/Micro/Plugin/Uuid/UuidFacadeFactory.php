<?php

namespace Micro\Plugin\Uuid;

use Micro\Plugin\Uuid\Business\UuidExtractorFactoryInterface;
use Micro\Plugin\Uuid\Business\UuidGeneratorFactoryInterface;

readonly class UuidFacadeFactory implements UuidFacadeFactoryInterface
{
    /**
     * @param UuidGeneratorFactoryInterface $generatorFactory
     * @param UuidExtractorFactoryInterface $extractorFactory
     */
    public function __construct(
        private UuidGeneratorFactoryInterface $generatorFactory,
        private UuidExtractorFactoryInterface $extractorFactory
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function create(): UuidFacadeInterface
    {
        return new UuidFacade(
            $this->generatorFactory,
            $this->extractorFactory
        );
    }
}
