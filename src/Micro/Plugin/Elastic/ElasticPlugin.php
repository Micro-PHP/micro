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

namespace Micro\Plugin\Elastic;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Framework\BootPluginDependent\Plugin\PluginDependedInterface;
use Micro\Plugin\Elastic\Client\Factory\ElasticClientFactory;
use Micro\Plugin\Elastic\Client\Factory\ElasticClientFactoryInterface;
use Micro\Plugin\Elastic\Configuration\ElasticPluginConfigurationInterface;
use Micro\Plugin\Elastic\Facade\ElasticFacade;
use Micro\Plugin\Elastic\Facade\ElasticFacadeInterface;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;
use Micro\Plugin\Logger\LoggerPlugin;

/**
 * @method ElasticPluginConfigurationInterface configuration()
 */
class ElasticPlugin implements DependencyProviderInterface, ConfigurableInterface, PluginDependedInterface
{
    use PluginConfigurationTrait;

    /**
     * @var LoggerFacadeInterface
     */
    private LoggerFacadeInterface $loggerFacade;

    public function provideDependencies(Container $container): void
    {
        $container->register(ElasticFacadeInterface::class, function (
            LoggerFacadeInterface $loggerFacade
        ) {
            $this->loggerFacade = $loggerFacade;

            return $this->createFacade();
        });
    }

    /**
     * @return ElasticClientFactoryInterface
     */
    public function createElasticClientFactory(): ElasticClientFactoryInterface
    {
        return new ElasticClientFactory(
            $this->configuration(),
            $this->loggerFacade
        );
    }

    /**
     * @return ElasticFacadeInterface
     */
    public function createFacade(): ElasticFacadeInterface
    {
        return new ElasticFacade(
            $this->createElasticClientFactory()
        );
    }

    public function getDependedPlugins(): iterable
    {
        return [
            LoggerPlugin::class,
        ];
    }
}
