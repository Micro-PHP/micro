<?php

namespace Micro\Plugin\Serializer\Facade;

use Micro\Plugin\Serializer\Business\Context\SerializerContextInterface;
use Micro\Plugin\Serializer\Business\Serializer\SerializerInterface;

readonly class SerializerFacade implements SerializerFacadeInterface
{
    public function __construct(
        private SerializerInterface $serializerPool
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(mixed $data, SerializerContextInterface $context): string
    {
        return $this->serializerPool->serialize($data, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function deserialize(mixed $data, SerializerContextInterface $context): mixed
    {
        return $this->serializerPool->deserialize($data, $context);
    }
}
