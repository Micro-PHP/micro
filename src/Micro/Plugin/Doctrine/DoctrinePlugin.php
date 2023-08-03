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

namespace Micro\Plugin\Doctrine;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Plugin\Doctrine\Business\Connection\ConnectionFactory;
use Micro\Plugin\Doctrine\Business\Connection\ConnectionFactoryInterface;
use Micro\Plugin\Doctrine\Business\EntityManager\EntityManagerFactory;
use Micro\Plugin\Doctrine\Business\EntityManager\EntityManagerFactoryInterface;
use Micro\Plugin\Doctrine\Business\Locator\EntityFileConfigurationLocatorFactory;
use Micro\Plugin\Doctrine\Business\Locator\EntityFileConfigurationLocatorFactoryInterface;
use Micro\Plugin\Doctrine\Business\Metadata\DriverMetadataFactory;
use Micro\Plugin\Doctrine\Business\Metadata\DriverMetadataFactoryInterface;
use Micro\Plugin\Doctrine\Business\Pool\EntityManagerPoolFactory;
use Micro\Plugin\Doctrine\Business\Pool\EntityManagerPoolFactoryInterface;

/**
 * Doctrine ORM Plugin.
 *  If appear Exception:
 *   - ExceptionConverter.php: An exception occurred in the driver: could not find driver
 *   - Doctrine\DBAL\Exception\DriverException: An exception occurred in the driver: could not find driver
 *  Solve: should php-dpo installed or other necessary driver.
 *  Example: apt install php8.2-pdo php8.2-mysql.
 *
 * @method DoctrinePluginConfigurationInterface configuration()
 */
class DoctrinePlugin implements DependencyProviderInterface, ConfigurableInterface
{
    use PluginConfigurationTrait;

    private KernelInterface $kernel;

    public function provideDependencies(Container $container): void
    {
        $container->register(DoctrineFacadeInterface::class, function (KernelInterface $kernel): DoctrineFacadeInterface {
            $this->kernel = $kernel;

            return $this->createDoctrineFacade();
        });
    }

    protected function createDoctrineFacade(): DoctrineFacadeInterface
    {
        return new DoctrineFacade($this->createManagerPool());
    }

    protected function createManagerPool(): EntityManagerPoolFactoryInterface
    {
        return new EntityManagerPoolFactory(
            $this->createEntityManagerFactory()
        );
    }

    protected function createEntityManagerFactory(): EntityManagerFactoryInterface
    {
        return new EntityManagerFactory(
            $this->createConnectionFactory(),
            $this->createDriverMetadataFactory(),
        );
    }

    protected function createConnectionFactory(): ConnectionFactoryInterface
    {
        return new ConnectionFactory(
            $this->configuration()
        );
    }

    protected function createDriverMetadataFactory(): DriverMetadataFactoryInterface
    {
        return new DriverMetadataFactory(
            $this->createEntityFileConfigurationLocatorFactory(),
            $this->configuration()
        );
    }

    protected function createEntityFileConfigurationLocatorFactory(): EntityFileConfigurationLocatorFactoryInterface
    {
        return new EntityFileConfigurationLocatorFactory($this->kernel);
    }
}
