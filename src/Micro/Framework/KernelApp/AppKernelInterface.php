<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\KernelApp;

use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\Kernel\Plugin\PluginBootLoaderInterface;

/**
 * Used to decorate the `micro/kernel` and simplify its creation.
 * By default, plugin configuration initialization and dependency provider initialization loaders have been added.
 *
 * **Installation**
 * ```bash
 * $ composer require micro/kernel-app
 * ```
 *
 * **Basic example**
 * ```php
 *   $applicationConfiguration = new class extends DefaultApplicationConfiguration {
 *
 *      private readonly Dotenv $dotenv;
 *
 *      public function __construct()
 *      {
 *          $basePath = dirname(__FILE__) . '/../';
 *          $_ENV['BASE_PATH'] =  $basePath;
 *          $env = getenv('APP_ENV') ?: 'dev';
 *
 *          $envFileCompiled = $basePath . '/' .  '.env.' .$env . '.php';
 *          if(file_exists($envFileCompiled)) {
 *              $content = include $envFileCompiled;
 *              parent::__construct($content);
 *
 *              return;
 *          }
 *
 *          $names[] = '.env';
 *          $names[] = '.env.' . $env;
 *          // Dotenv library is not included by default. Used for example.
 *          $this->dotenv = Dotenv::createMutable($basePath, $names, false);
 *          $this->dotenv->load();
 *
 *          parent::__construct($_ENV);
 *      }
 *   };
 *
 *   $kernel =  new AppKernel(
 *      $applicationConfiguration,
 *      [
 *          SomePlugin::class,
 *          AnotherPlugin::class,
 *      ],
 *      $applicationConfiguration->get('APP_ENV', 'dev')
 *   );
 *
 *   $kernel->run();
 * ```
 *
 * @api
 */
interface AppKernelInterface extends KernelInterface
{
    public function environment(): string;

    public function isDevMode(): bool;

    /**
     * @return $this
     */
    public function addBootLoader(PluginBootLoaderInterface $bootLoader): self;

    /**
     * Microkernel\App\Business\Event\Application Terminated Event will be fired.
     */
    public function terminate(): void;
}
