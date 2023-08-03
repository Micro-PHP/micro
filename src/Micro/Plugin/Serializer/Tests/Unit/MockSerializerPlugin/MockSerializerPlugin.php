<?php

declare(strict_types=1);

namespace Micro\Plugin\Serializer\Tests\Unit\MockSerializerPlugin;

use Micro\Plugin\Serializer\Business\Context\SerializerContextInterface;
use Micro\Plugin\Serializer\Plugin\SerializerAdapterPluginInterface;
use Micro\Plugin\Serializer\Plugin\SerializerInterface;
use Micro\Plugin\Serializer\Tests\Unit\MockSerializerPlugin\Context\MockSerializerContext;

class MockSerializerPlugin implements SerializerAdapterPluginInterface
{
    public function createSerializer(): SerializerInterface
    {
        return new class() implements SerializerInterface {
            public function serialize(mixed $data, SerializerContextInterface $context): string
            {
                return json_encode(['class' => \get_class($data), 'metadata' => ['some sort of metadata'], 'data' => $data]);
            }

            public function deserialize(mixed $data, SerializerContextInterface $context): mixed
            {
                $rawDecoded = json_decode($data, true);

                $class = $rawDecoded['class'];

                $obj = new $class();

                foreach ($rawDecoded['data'] as $property => $value) {
                    $obj->{$property} = $value;
                }

                return $obj;
            }

            public function supports(SerializerContextInterface $serializerContext): bool
            {
                return $serializerContext instanceof MockSerializerContext;
            }
        };
    }
}
