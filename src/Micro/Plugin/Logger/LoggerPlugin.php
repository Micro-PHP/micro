<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Logger;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Plugin\Logger\Business\Provider\LoggerProvider;
use Micro\Plugin\Logger\Business\Provider\LoggerProviderInterface;
use Micro\Plugin\Logger\Configuration\LoggerPluginConfigurationInterface;
use Micro\Plugin\Logger\Facade\LoggerFacade;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 *
 * @method LoggerPluginConfigurationInterface configuration()
 */
class LoggerPlugin implements DependencyProviderInterface, ConfigurableInterface
{
    use PluginConfigurationTrait;

    private ?LoggerProviderInterface $loggerProvider = null;

    private KernelInterface $kernel;

    public function provideDependencies(Container $container): void
    {
        $container->register(LoggerFacadeInterface::class, function (
            KernelInterface $kernel
        ) {
            $this->kernel = $kernel;

            return $this->createLoggerFacade();
        });
    }

    protected function getLoggerProvider(): LoggerProviderInterface
    {
        if (!$this->loggerProvider) {
            $this->loggerProvider = $this->createLoggerProvider();
        }

        return $this->loggerProvider;
    }

    protected function createLoggerProvider(): LoggerProviderInterface
    {
        return new LoggerProvider(
            $this->kernel,
            $this->configuration()
        );
    }

    protected function createLoggerFacade(): LoggerFacadeInterface
    {
        return new LoggerFacade($this->getLoggerProvider());
    }
}
