<?php

namespace Micro\Plugin\Uuid\Business;

use Ramsey\Uuid\Uuid;

class UuidExtractor implements UuidExtractorInterface
{
    /**
     * {@inheritDoc}
     */
    public function fromString(string $uuid): string
    {
        return Uuid::fromString($uuid)->toString();
    }

    /**
     * {@inheritDoc}
     */
    public function fromBytes(string $bytes): string
    {
        return Uuid::fromBytes($bytes)->toString();
    }

    /**
     * {@inheritDoc}
     */
    public function fromInteger(string $integer): string
    {
        return Uuid::fromInteger($integer)->toString();
    }

    /**
     * {@inheritDoc}
     */
    public function fromDatetime(\DateTimeInterface $dateTime): string
    {
        return Uuid::fromDateTime($dateTime)->toString();
    }
}
