<?php

declare(strict_types=1);

namespace Micro\Plugin\Serializer\Tests\Unit\Business\Pool;

use Micro\Framework\Kernel\Kernel;
use Micro\Plugin\Serializer\Business\Context\SerializerContextInterface;
use Micro\Plugin\Serializer\Business\Pool\SerializerPool;
use Micro\Plugin\Serializer\Exception\SerializerNotFoundException;
use Micro\Plugin\Serializer\Plugin\SerializerAdapterPluginInterface;
use Micro\Plugin\Serializer\Plugin\SerializerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SerializerPoolTest extends TestCase
{
    private MockObject&Kernel $kernelMock;

    private MockObject&SerializerAdapterPluginInterface $serializerProviderPluginMock;

    private MockObject&SerializerInterface $serializerMock;

    private MockObject&SerializerContextInterface $serializerContextMock;

    protected function setUp(): void
    {
        $this->kernelMock = $this->getMockBuilder(Kernel::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->serializerProviderPluginMock = $this->getMockBuilder(SerializerAdapterPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->serializerMock = $this->getMockBuilder(SerializerInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->serializerContextMock = $this->getMockBuilder(SerializerContextInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
    }

    public function testSerialize(): void
    {
        $serializerPool = new SerializerPool($this->kernelMock);

        $this->kernelMock->expects($this->once())
            ->method('plugins')
            ->with(SerializerAdapterPluginInterface::class)
            ->willReturn(new \ArrayObject([$this->serializerProviderPluginMock]));

        $this->serializerProviderPluginMock->expects($this->once())
            ->method('createSerializer')
            ->willReturn($this->serializerMock);

        $this->serializerMock->expects($this->once())
            ->method('supports')
            ->with($this->serializerContextMock)
            ->willReturn(true);

        $this->serializerMock->expects($this->exactly(2))
            ->method('serialize')
            ->withConsecutive(['data', $this->serializerContextMock], ['another data', $this->serializerContextMock])
            ->willReturn('serialized data');

        $serializerPool->serialize('data', $this->serializerContextMock);
        $serializerPool->serialize('another data', $this->serializerContextMock);
    }

    public function testDeserialize(): void
    {
        $serializerPool = new SerializerPool($this->kernelMock);

        $this->kernelMock->expects($this->once())
            ->method('plugins')
            ->with(SerializerAdapterPluginInterface::class)
            ->willReturn(new \ArrayObject([$this->serializerProviderPluginMock]));

        $this->serializerProviderPluginMock->expects($this->once())
            ->method('createSerializer')
            ->willReturn($this->serializerMock);

        $this->serializerMock->expects($this->once())
            ->method('supports')
            ->with($this->serializerContextMock)
            ->willReturn(true);

        $this->serializerMock->expects($this->exactly(2))
            ->method('deserialize')
            ->withConsecutive(['data', $this->serializerContextMock], ['another data', $this->serializerContextMock])
            ->willReturn('deserialized data');

        $serializerPool->deserialize('data', $this->serializerContextMock);
        $serializerPool->deserialize('another data', $this->serializerContextMock);
    }

    public function testSerializerNotFoundSerialize(): void
    {
        $serializerPool = new SerializerPool($this->kernelMock);

        $this->kernelMock->expects($this->once())
            ->method('plugins')
            ->with(SerializerAdapterPluginInterface::class)
            ->willReturn(new \ArrayObject([$this->serializerProviderPluginMock]));

        $this->serializerProviderPluginMock->expects($this->once())
            ->method('createSerializer')
            ->willReturn($this->serializerMock);

        $this->serializerMock->expects($this->once())
            ->method('supports')
            ->with($this->serializerContextMock)
            ->willReturn(false);

        $this->serializerMock->expects($this->never())
            ->method('serialize');

        $this->expectException(SerializerNotFoundException::class);

        $serializerPool->serialize('data', $this->serializerContextMock);
    }

    public function testSerializerNotFoundDeserialize(): void
    {
        $serializerPool = new SerializerPool($this->kernelMock);

        $this->kernelMock->expects($this->once())
            ->method('plugins')
            ->with(SerializerAdapterPluginInterface::class)
            ->willReturn(new \ArrayObject([$this->serializerProviderPluginMock]));

        $this->serializerProviderPluginMock->expects($this->once())
            ->method('createSerializer')
            ->willReturn($this->serializerMock);

        $this->serializerMock->expects($this->once())
            ->method('supports')
            ->with($this->serializerContextMock)
            ->willReturn(false);

        $this->serializerMock->expects($this->never())
            ->method('deserialize');

        $this->expectException(SerializerNotFoundException::class);

        $serializerPool->deserialize('data', $this->serializerContextMock);
    }
}
