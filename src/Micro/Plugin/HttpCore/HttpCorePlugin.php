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

namespace Micro\Plugin\HttpCore;

use Micro\Framework\Autowire\AutowireHelperFactory;
use Micro\Framework\Autowire\AutowireHelperFactoryInterface;
use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Framework\BootPluginDependent\Plugin\PluginDependedInterface;
use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorFactory;
use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorFactoryInterface;
use Micro\Plugin\HttpCore\Business\Generator\UrlGeneratorFactory;
use Micro\Plugin\HttpCore\Business\Generator\UrlGeneratorFactoryInterface;
use Micro\Plugin\HttpCore\Business\Locator\RouteLocatorFactory;
use Micro\Plugin\HttpCore\Business\Locator\RouteLocatorFactoryInterface;
use Micro\Plugin\HttpCore\Business\Matcher\Route\RouteMatcherFactory;
use Micro\Plugin\HttpCore\Business\Matcher\Route\RouteMatcherFactoryInterface;
use Micro\Plugin\HttpCore\Business\Matcher\UrlMatcherFactory;
use Micro\Plugin\HttpCore\Business\Matcher\UrlMatcherFactoryInterface;
use Micro\Plugin\HttpCore\Business\Response\Callback\ResponseCallbackFactory;
use Micro\Plugin\HttpCore\Business\Response\Callback\ResponseCallbackFactoryInterface;
use Micro\Plugin\HttpCore\Business\Response\Transformer\ResponseTransformerFactory;
use Micro\Plugin\HttpCore\Business\Response\Transformer\ResponseTransformerFactoryInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteBuilderFactory;
use Micro\Plugin\HttpCore\Business\Route\RouteBuilderFactoryInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteCollectionFactory;
use Micro\Plugin\HttpCore\Business\Route\RouteCollectionFactoryInterface;
use Micro\Plugin\HttpCore\Configuration\HttpCorePluginConfigurationInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacade;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Micro\Plugin\Locator\LocatorPlugin;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 *
 * @method HttpCorePluginConfigurationInterface configuration()
 */
class HttpCorePlugin implements DependencyProviderInterface, ConfigurableInterface, PluginDependedInterface
{
    use PluginConfigurationTrait;

    private KernelInterface $kernel;

    private Container $container;

    public function provideDependencies(Container $container): void
    {
        $this->container = $container;

        $container->register(HttpFacadeInterface::class, function (
            KernelInterface $kernel
        ) {
            $this->kernel = $kernel;

            return $this->createFacade();
        });
    }

    protected function createFacade(): HttpFacadeInterface
    {
        $routeCollectionFactory = $this->createRouteCollectionFactory();
        $routeMatcherFactory = $this->createRouteMatcherFactory();

        $urlMatcherFactory = $this->createUrlMatcherFactory(
            $routeCollectionFactory,
            $routeMatcherFactory
        );

        return new HttpFacade(
            $urlMatcherFactory,
            $routeCollectionFactory,
            $this->createRouteExecutorFactory($urlMatcherFactory),
            $this->createRouteBuilderFactory(),
            $this->createUrlGeneratorFactory($routeCollectionFactory)
        );
    }

    protected function createUrlGeneratorFactory(RouteCollectionFactoryInterface $routeCollectionFactory): UrlGeneratorFactoryInterface
    {
        return new UrlGeneratorFactory($routeCollectionFactory);
    }

    protected function createRouteBuilderFactory(): RouteBuilderFactoryInterface
    {
        return new RouteBuilderFactory();
    }

    protected function createRouteMatcherFactory(): RouteMatcherFactoryInterface
    {
        return new RouteMatcherFactory();
    }

    protected function createUrlMatcherFactory(
        RouteCollectionFactoryInterface $routeCollectionFactory,
        RouteMatcherFactoryInterface $routeMatcherFactory
    ): UrlMatcherFactoryInterface {
        return new UrlMatcherFactory(
            $routeCollectionFactory,
            $routeMatcherFactory
        );
    }

    /**
     * @throws \RuntimeException
     */
    protected function createRouteCollectionFactory(): RouteCollectionFactoryInterface
    {
        return new RouteCollectionFactory(
            $this->createRouteLocatorFactory()
        );
    }

    protected function createRouteLocatorFactory(): RouteLocatorFactoryInterface
    {
        return new RouteLocatorFactory(
            $this->kernel,
            $this->configuration()
        );
    }

    protected function createResponseCallbackFactory(): ResponseCallbackFactoryInterface
    {
        return new ResponseCallbackFactory(
            $this->createAutowireHelperFactory()
        );
    }

    protected function createAutowireHelperFactory(): AutowireHelperFactoryInterface
    {
        return new AutowireHelperFactory($this->container);
    }

    protected function createRouteExecutorFactory(
        UrlMatcherFactoryInterface $urlMatcherFactory,
    ): RouteExecutorFactoryInterface {
        return new RouteExecutorFactory(
            $urlMatcherFactory,
            $this->container,
            $this->createResponseCallbackFactory(),
            $this->createResponseTransformerFactory()
        );
    }

    protected function createResponseTransformerFactory(): ResponseTransformerFactoryInterface
    {
        return new ResponseTransformerFactory(
            $this->kernel
        );
    }

    public function getDependedPlugins(): iterable
    {
        return [
            LocatorPlugin::class,
        ];
    }
}
