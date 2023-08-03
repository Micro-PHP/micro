<?php

namespace Micro\Plugin\Uuid;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Plugin\Uuid\Business\UuidExtractorFactory;
use Micro\Plugin\Uuid\Business\UuidExtractorFactoryInterface;
use Micro\Plugin\Uuid\Business\UuidGeneratorFactory;
use Micro\Plugin\Uuid\Business\UuidGeneratorFactoryInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class UuidPlugin implements DependencyProviderInterface
{
    public function provideDependencies(Container $container): void
    {
        $container->register(UuidFacadeInterface::class, function() {
            return $this->createUuidFacadeFactory()->create();
        });
    }

    /**
     * @return UuidFacadeFactoryInterface
     */
    protected function createUuidFacadeFactory(): UuidFacadeFactoryInterface
    {
        return new UuidFacadeFactory(
            $this->createUuidGeneratorFactory(),
            $this->createUuidExtractorFactory()
        );
    }

    /**
     * @return UuidGeneratorFactoryInterface
     */
    protected function createUuidGeneratorFactory(): UuidGeneratorFactoryInterface
    {
        return new UuidGeneratorFactory();
    }

    /**
     * @return UuidExtractorFactoryInterface
     */
    protected function createUuidExtractorFactory(): UuidExtractorFactoryInterface
    {
        return new UuidExtractorFactory();
    }
}
