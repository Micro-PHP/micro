<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\DTO;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Framework\BootPluginDependent\Plugin\PluginDependedInterface;
use Micro\Framework\KernelApp\AppKernelInterface;
use Micro\Library\DTO\SerializerFacadeDefault;
use Micro\Library\DTO\SerializerFacadeInterface;
use Micro\Library\DTO\ValidatorFacadeDefault;
use Micro\Library\DTO\ValidatorFacadeInterface;
use Micro\Plugin\DTO\Business\FileLocator\FileLocatorFactory;
use Micro\Plugin\DTO\Business\FileLocator\FileLocatorFactoryInterface;
use Micro\Plugin\DTO\Business\Generator\GeneratorFactory;
use Micro\Plugin\DTO\Business\Generator\GeneratorFactoryInterface;
use Micro\Plugin\DTO\Facade\DTOFacade;
use Micro\Plugin\DTO\Facade\DTOFacadeInterface;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;
use Micro\Plugin\Logger\LoggerPlugin;

/**
 * @method DTOPluginConfigurationInterface configuration()
 */
class DTOPlugin implements DependencyProviderInterface, ConfigurableInterface, PluginDependedInterface
{
    use PluginConfigurationTrait;

    private AppKernelInterface $kernel;

    private LoggerFacadeInterface $loggerFacade;

    public function provideDependencies(Container $container): void
    {
        $container->register(DTOFacadeInterface::class, function (
            AppKernelInterface $kernel,
            LoggerFacadeInterface $loggerFacade
        ) {
            $this->kernel = $kernel;
            $this->loggerFacade = $loggerFacade;

            return $this->createDTOGeneratorFacade();
        });

        $container->register(SerializerFacadeInterface::class, function () {
            return $this->createDTOSerializerFacade();
        });

        $container->register(ValidatorFacadeInterface::class, function () {
            return $this->createDtoValidatorFacade();
        });
    }

    public function getDependedPlugins(): iterable
    {
        return [
            LoggerPlugin::class,
        ];
    }

    /**
     * @return SerializerFacadeInterface
     */
    protected function createDTOSerializerFacade(): SerializerFacadeInterface
    {
        return new SerializerFacadeDefault();
    }

    protected function createDtoValidatorFacade(): ValidatorFacadeInterface
    {
        return new ValidatorFacadeDefault();
    }

    /**
     * @return DTOFacadeInterface
     */
    protected function createDTOGeneratorFacade(): DTOFacadeInterface
    {
        return new DTOFacade($this->createGeneratorFactory());
    }

    /**
     * @return GeneratorFactoryInterface
     */
    protected function createGeneratorFactory(): GeneratorFactoryInterface
    {
        return new GeneratorFactory(
            $this->createFileLocatorFactory(),
            $this->configuration(),
            $this->loggerFacade
        );
    }

    /**
     * @return FileLocatorFactoryInterface
     */
    protected function createFileLocatorFactory(): FileLocatorFactoryInterface
    {
        return new FileLocatorFactory(
            appKernel: $this->kernel,
            DTOPluginConfiguration: $this->configuration()
        );
    }
}
