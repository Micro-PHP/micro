<?php

declare(strict_types=1);

namespace Micro\Plugin\Serializer\Tests\Unit;

use Micro\Framework\KernelApp\AppKernel;
use Micro\Plugin\Serializer\Facade\SerializerFacadeInterface;
use Micro\Plugin\Serializer\SerializerPlugin;
use Micro\Plugin\Serializer\Tests\Unit\MockSerializerPlugin\Context\MockSerializerContext;
use Micro\Plugin\Serializer\Tests\Unit\MockSerializerPlugin\MockSerializerPlugin;
use PHPUnit\Framework\TestCase;

class SerializerPluginTest extends TestCase
{
    public function testSerializerFacade()
    {
        $kernel = new AppKernel([], [
            SerializerPlugin::class,
            MockSerializerPlugin::class,
        ]);

        $kernel->run();
        $facade = $kernel->container()->get(SerializerFacadeInterface::class);
        $mockDto = new \stdClass();
        $mockDto->foo = 'bar';
        $mockDto->bar = 'foo';
        $serialized = $facade->serialize($mockDto, new MockSerializerContext(null, 'json'));
        $this->assertEquals('{"class":"stdClass","metadata":["some sort of metadata"],"data":{"foo":"bar","bar":"foo"}}', $serialized);
        $deserialized = $facade->deserialize($serialized, new MockSerializerContext('json', null));
        $this->assertEquals($mockDto, $deserialized);
    }
}
