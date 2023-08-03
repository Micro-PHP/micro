<?php

declare(strict_types=1);

namespace Micro\Plugin\Serializer\Business\Serializer;

use Micro\Plugin\Serializer\Business\Context\SerializerContextInterface;
use Micro\Plugin\Serializer\Exception\SerializeException;

interface SerializerInterface
{
    /**
     * Serializes data in the appropriate format.
     *
     * @throws SerializeException
     */
    public function serialize(mixed $data, SerializerContextInterface $context): string;

    /**
     * Deserializes data into the given type.
     *
     * @throws SerializeException
     */
    public function deserialize(mixed $data, SerializerContextInterface $context): mixed;
}
