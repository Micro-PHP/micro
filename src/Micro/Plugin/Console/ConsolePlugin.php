<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Console;

use Micro\Framework\Autowire\AutowireHelperFactory;
use Micro\Framework\Autowire\AutowireHelperFactoryInterface;
use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Plugin\Console\Business\Factory\ConsoleApplicationFactory;
use Micro\Plugin\Console\Business\Factory\ConsoleApplicationFactoryInterface;
use Micro\Plugin\Console\Facade\ConsoleApplicationFacade;
use Micro\Plugin\Console\Facade\ConsoleApplicationFacadeInterface;
use Micro\Plugin\Locator\Facade\LocatorFacadeInterface;

/**
 * A plugin that allows you to provide a console interface for executing commands.
 *
 * All application classes that inherit "Symfony\Component\Console\Command\Command" will be automatically found and, if necessary, all dependencies will be automatically provided to the constructor.
 *
 * The plugin is an adapter for the <a href="https://symfony.com/doc/current/components/console.html#learn-more" target="_blank">symfony/console</a> component.
 *
 * **Installation**
 * Install plugin
 * ```bash
 * $ composer require micro/plugin-console
 * ```
 *
 * Enable plugin
 * ```php
 * // /etc/plugins.php
 *
 * return [
 *      // ...other bundles
 *      Micro\Plugin\Console\ConsolePlugin::class
 * ];
 * ```
 * Register command
 * ```php
 *
 * use Symfony\Component\Console\Command\Command;
 * use Symfony\Component\Console\Input\InputInterface;
 * use Symfony\Component\Console\Output\OutputInterface;
 *
 * class MyTestCommand extends Command
 * {
 *      public function __construct(
 *          private readonly SomeDependentFacadeInterface $dependentService
 *      )
 *      {
 *          parent::__construct('test:command');
 *      }
 *
 *      public function configure()
 *      {
 *          // Configure some options and arguments
 *      }
 *
 *      public function execute(InputInterface $input, OutputInterface $output)
 *      {
 *          $result = $this->dependentService->doSomething($input->getArgument('some-configured-argument'));
 *
 *          $output->writeln('Result: ' . $result);
 *
 *          return self::SUCCESS;
 *      }
 * }
 * ```
 *
 *  Execute
 * ```bash
 * $ php bin/console test:command
 * ```
 *
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 *
 * @api
 */
class ConsolePlugin implements DependencyProviderInterface
{
    private LocatorFacadeInterface $locatorFacade;

    private AutowireHelperFactoryInterface $autowireHelperFactory;

    public function provideDependencies(Container $container): void
    {
        $container->register(
            ConsoleApplicationFacadeInterface::class, function (
                LocatorFacadeInterface $locatorFacade,
                Container $container
            ): ConsoleApplicationFacadeInterface {
                $this->locatorFacade = $locatorFacade;
                $this->autowireHelperFactory = new AutowireHelperFactory($container);

                return new ConsoleApplicationFacade($this->createConsoleApplicationFactory());
            }
        );
    }

    protected function createConsoleApplicationFactory(): ConsoleApplicationFactoryInterface
    {
        return new ConsoleApplicationFactory(
            $this->locatorFacade,
            $this->autowireHelperFactory->create()
        );
    }
}
