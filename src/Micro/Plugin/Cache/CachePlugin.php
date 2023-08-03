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

namespace Micro\Plugin\Cache;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Plugin\Cache\Business\Adapter\AdapterFactory;
use Micro\Plugin\Cache\Business\Adapter\AdapterFactoryInterface;
use Micro\Plugin\Cache\Business\Adapter\Concrete\ApcuFactory;
use Micro\Plugin\Cache\Business\Adapter\Concrete\ArrayFactory;
use Micro\Plugin\Cache\Business\Adapter\Concrete\FilesystemFactory;
use Micro\Plugin\Cache\Business\Adapter\Concrete\PdoFactory;
use Micro\Plugin\Cache\Business\Adapter\Concrete\PhpFilesFactory;
use Micro\Plugin\Cache\Business\Adapter\Concrete\RedisFactory;
use Micro\Plugin\Cache\Business\Pool\CachePoolFactory;
use Micro\Plugin\Cache\Business\Pool\CachePoolFactoryInterface;
use Micro\Plugin\Cache\Configuration\CachePluginConfigurationInterface;
use Micro\Plugin\Cache\Facade\CacheFacade;
use Micro\Plugin\Cache\Facade\CacheFacadeInterface;

/**
 * @method CachePluginConfigurationInterface configuration()
 */
class CachePlugin implements DependencyProviderInterface, ConfigurableInterface
{
    use PluginConfigurationTrait;

    private Container $container;

    public function provideDependencies(Container $container): void
    {
        $this->container = $container;

        $container->register(CacheFacadeInterface::class, function (): CacheFacadeInterface {
            return $this->createFacade();
        });
    }

    protected function createFacade(): CacheFacadeInterface
    {
        return new CacheFacade(
            $this->createCachePoolFactory()
        );
    }

    protected function createCachePoolFactory(): CachePoolFactoryInterface
    {
        return new CachePoolFactory(
            $this->createAdapterFactory()
        );
    }

    protected function createAdapterFactory(): AdapterFactoryInterface
    {
        return new AdapterFactory(
            $this->configuration(),
            [
                new ApcuFactory(),
                new ArrayFactory(),
                new FilesystemFactory(),
                new PdoFactory($this->container),
                new RedisFactory($this->container),
                new PhpFilesFactory(),
            ]
        );
    }
}
