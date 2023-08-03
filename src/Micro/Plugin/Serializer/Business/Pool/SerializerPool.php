<?php

declare(strict_types=1);

namespace Micro\Plugin\Serializer\Business\Pool;

use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\Serializer\Business\Context\SerializerContextInterface;
use Micro\Plugin\Serializer\Business\Serializer\SerializerInterface;
use Micro\Plugin\Serializer\Exception\SerializerNotFoundException;
use Micro\Plugin\Serializer\Plugin\SerializerAdapterPluginInterface;
use Micro\Plugin\Serializer\Plugin\SerializerInterface as PluginSerializerInterface;

class SerializerPool implements SerializerInterface
{
    /**
     * @var array<string, SerializerInterface>
     */
    private array $serializerPoolByContext = [];

    public function __construct(private readonly KernelInterface $kernel)
    {
    }

    public function serialize(mixed $data, SerializerContextInterface $context): string
    {
        if (\array_key_exists($contextClass = \get_class($context), $this->serializerPoolByContext)) {
            return $this->serializerPoolByContext[$contextClass]->serialize($data, $context);
        }

        $serializers = $this->getSerializers();

        foreach ($serializers as $serializer) {
            if (!$serializer->supports($context)) {
                continue;
            }

            $this->serializerPoolByContext[$contextClass] = $serializer;

            return $serializer->serialize($data, $context);
        }

        throw new SerializerNotFoundException(sprintf('There are no serializer available for context %s.', $contextClass));
    }

    public function deserialize(mixed $data, SerializerContextInterface $context): mixed
    {
        if (\array_key_exists($contextClass = \get_class($context), $this->serializerPoolByContext)) {
            return $this->serializerPoolByContext[$contextClass]->deserialize($data, $context);
        }

        $serializers = $this->getSerializers();

        foreach ($serializers as $serializer) {
            if (!$serializer->supports($context)) {
                continue;
            }

            $this->serializerPoolByContext[$contextClass] = $serializer;

            return $serializer->deserialize($data, $context);
        }

        throw new SerializerNotFoundException(<<<EOF
            There are no serializer available.
            You should install one of the serializer plugin.
            We recommend using the package `micro/plugin-serializer-symfony`.
            EOF);
    }

    /**
     * @return PluginSerializerInterface[]
     */
    protected function getSerializers(): iterable
    {
        $iterator = $this->kernel->plugins(SerializerAdapterPluginInterface::class);

        /** @var SerializerAdapterPluginInterface $serializerProviderPlugin */
        foreach ($iterator as $serializerProviderPlugin) {
            yield $serializerProviderPlugin->createSerializer();
        }
    }
}
