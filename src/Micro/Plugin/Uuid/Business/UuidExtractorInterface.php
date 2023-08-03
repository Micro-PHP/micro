<?php

namespace Micro\Plugin\Uuid\Business;

interface UuidExtractorInterface
{
    /**
     * Creates a UUID from a string UUID.
     */
    public function fromString(string $uuid): string;

    /**
     * Creates a UUID from a 16-byte string.
     */
    public function fromBytes(string $bytes): string;

    /**
     * Creates a UUID from a string integer.
     */
    public function fromInteger(string $integer): string;

    /**
     * Creates a UUID from a DateTimeInterface instance
     */
    public function fromDatetime(\DateTimeInterface $dateTime): string;
}
