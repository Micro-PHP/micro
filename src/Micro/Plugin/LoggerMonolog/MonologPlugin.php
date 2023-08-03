<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\LoggerMonolog;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Framework\BootPluginDependent\Plugin\PluginDependedInterface;
use Micro\Plugin\Logger\Business\Factory\LoggerFactoryInterface;
use Micro\Plugin\Logger\LoggerPlugin;
use Micro\Plugin\LoggerMonolog\Business\Factory\LoggerFactory;
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerFactory;
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerFactoryInterface;
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerProvider;
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerProviderInterface;
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerResolverFactory;
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerResolverFactoryInterface;
use Micro\Plugin\LoggerMonolog\Configuration\Handler\HandlerConfigurationFactory;
use Micro\Plugin\LoggerMonolog\Configuration\Handler\HandlerConfigurationFactoryInterface;
use Micro\Plugin\LoggerMonolog\Configuration\Handler\HandlerConfigurationInterface;
use Micro\Plugin\LoggerMonolog\Configuration\Handler\Type\HandlerStreamConfiguration;
use Micro\Plugin\LoggerMonolog\Configuration\Logger\MonologPluginConfigurationInterface;
use Micro\Plugin\Logger\Plugin\LoggerProviderPluginInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 *
 * @method MonologPluginConfigurationInterface configuration()
 */
class MonologPlugin implements DependencyProviderInterface, PluginDependedInterface, LoggerProviderPluginInterface, ConfigurableInterface
{
    use PluginConfigurationTrait;

    private ?HandlerProviderInterface $handlerProvider = null;

    private Container $container;

    public function provideDependencies(Container $container): void
    {
        $this->container = $container;
    }

    protected function createLoggerFactory(): LoggerFactoryInterface
    {
        return new LoggerFactory(
            $this->createHandlerResolverFactory()
        );
    }

    protected function createHandlerProvider(): HandlerProviderInterface
    {
        if (!$this->handlerProvider) {
            $this->handlerProvider = new HandlerProvider($this->createHandlerFactory());
        }

        return $this->handlerProvider;
    }

    protected function createHandlerFactory(): HandlerFactoryInterface
    {
        return new HandlerFactory(
            $this->container,
            $this->createHandlerConfigurationFactory()
        );
    }

    protected function createHandlerConfigurationFactory(): HandlerConfigurationFactoryInterface
    {
        return new HandlerConfigurationFactory(
            $this->configuration(),
            $this->getHandlerConfigurationClassCollection()
        );
    }

    protected function createHandlerResolverFactory(): HandlerResolverFactoryInterface
    {
        return new HandlerResolverFactory(
            $this->configuration(),
            $this->createHandlerProvider()
        );
    }

    /**
     * @return iterable<class-string<HandlerConfigurationInterface>>
     */
    protected function getHandlerConfigurationClassCollection(): iterable
    {
        return [
            HandlerStreamConfiguration::class,
        ];
    }

    public function getLoggerFactory(): LoggerFactoryInterface
    {
        return $this->createLoggerFactory();
    }

    public function getLoggerAdapterName(): string
    {
        return 'monolog';
    }

    public function getDependedPlugins(): iterable
    {
        return [
            LoggerPlugin::class,
        ];
    }
}
