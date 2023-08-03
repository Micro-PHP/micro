<?php

namespace Micro\Plugin\Uuid;

use Micro\Plugin\Uuid\Business\UuidExtractorFactoryInterface;
use Micro\Plugin\Uuid\Business\UuidGeneratorFactoryInterface;

readonly class UuidFacade implements UuidFacadeInterface
{
    /**
     * @param UuidGeneratorFactoryInterface $generatorFactory
     * @param UuidExtractorFactoryInterface $extractorFactory
     */
    public function __construct(
        private UuidGeneratorFactoryInterface $generatorFactory,
        private UuidExtractorFactoryInterface $extractorFactory
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function v1(): string
    {
        return $this->generatorFactory->create()->v1();
    }

    /**
     * {@inheritDoc}
     */
    public function v3(string $namespace): string
    {
        return $this->generatorFactory->create()->v3($namespace);
    }

    /**
     * {@inheritDoc}
     */
    public function v4(): string
    {
        return $this->generatorFactory->create()->v4();
    }

    /**
     * {@inheritDoc}
     */
    public function v5(string $namespace): string
    {
        return $this->generatorFactory->create()->v5($namespace);
    }

    /**
     * {@inheritDoc}
     */
    public function fromString(string $uuid): string
    {
        return $this->extractorFactory->create()->fromString($uuid);
    }

    /**
     * {@inheritDoc}
     */
    public function fromBytes(string $bytes): string
    {
        return $this->extractorFactory->create()->fromBytes($bytes);
    }

    /**
     * {@inheritDoc}
     */
    public function fromInteger(string $integer): string
    {
        return $this->extractorFactory->create()->fromInteger($integer);
    }

    /**
     * {@inheritDoc}
     */
    public function fromDatetime(\DateTimeInterface $dateTime): string
    {
        return $this->extractorFactory->create()->fromDatetime($dateTime);
    }
}
