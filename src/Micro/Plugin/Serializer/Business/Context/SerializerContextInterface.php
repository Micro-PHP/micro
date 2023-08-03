<?php

declare(strict_types=1);

namespace Micro\Plugin\Serializer\Business\Context;

interface SerializerContextInterface
{
    public function getSourceFormat(): ?string;

    public function getDestinationFormat(): ?string;

    /**
     * @return array<string, mixed>
     */
    public function getContext(): array;
}
