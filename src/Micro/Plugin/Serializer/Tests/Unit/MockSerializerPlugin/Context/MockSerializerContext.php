<?php

declare(strict_types=1);

namespace Micro\Plugin\Serializer\Tests\Unit\MockSerializerPlugin\Context;

use Micro\Plugin\Serializer\Business\Context\SerializerContextInterface;

readonly class MockSerializerContext implements SerializerContextInterface
{
    public function __construct(
        private ?string $sourceFormat,
        private ?string $destinationFormat,
        private array $context = []
    ) {
    }

    public function getSourceFormat(): ?string
    {
        return $this->sourceFormat;
    }

    public function getDestinationFormat(): ?string
    {
        return $this->destinationFormat;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
