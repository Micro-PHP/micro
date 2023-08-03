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

namespace Micro\Plugin\HttpExceptionsDev;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Framework\BootPluginDependent\Plugin\PluginDependedInterface;
use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorFactoryInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Micro\Plugin\HttpCore\HttpCorePlugin;
use Micro\Plugin\HttpExceptionsDev\Business\Exception\Renderer\RendererFactory;
use Micro\Plugin\HttpExceptionsDev\Business\Exception\Renderer\RendererFactoryInterface;
use Micro\Plugin\HttpExceptionsDev\Business\Executor\HttpExceptionPageExecutorDecoratorFactory;
use Micro\Plugin\HttpExceptionsDev\Configuration\HttpExceptionResponseDevPluginConfigurationInterface;
use Micro\Plugin\HttpExceptionsDev\Decorator\HttpFacadeExceptionDevDecorator;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 *
 * @method HttpExceptionResponseDevPluginConfigurationInterface configuration()
 */
class HttpExceptionResponseDevPlugin implements ConfigurableInterface, DependencyProviderInterface, PluginDependedInterface
{
    use PluginConfigurationTrait;

    private HttpFacadeInterface $httpFacade;

    public function provideDependencies(Container $container): void
    {
        $container->decorate(HttpFacadeInterface::class, function (
            HttpFacadeInterface $httpFacade
        ) {
            $this->httpFacade = $httpFacade;

            return $this->createDecorator();
        });
    }

    protected function createDecorator(): HttpFacadeInterface
    {
        return new HttpFacadeExceptionDevDecorator(
            $this->httpFacade,
            $this->createRouteExecutorFactory()
        );
    }

    protected function createRouteExecutorFactory(): RouteExecutorFactoryInterface
    {
        return new HttpExceptionPageExecutorDecoratorFactory(
            $this->httpFacade,
            $this->createExceptionRendererFactory(),
            $this->configuration()
        );
    }

    protected function createExceptionRendererFactory(): RendererFactoryInterface
    {
        return new RendererFactory($this->configuration());
    }

    public function getDependedPlugins(): iterable
    {
        return [
            HttpCorePlugin::class,
        ];
    }
}
