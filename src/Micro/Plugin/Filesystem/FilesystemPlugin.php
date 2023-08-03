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

namespace Micro\Plugin\Filesystem;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Plugin\Filesystem\Configuration\FilesystemPluginConfigurationInterface;
use Micro\Plugin\Filesystem\Facade\FilesystemFacade;
use Micro\Plugin\Filesystem\Facade\FilesystemFacadeInterface;

/**
 * @method FilesystemPluginConfigurationInterface configuration()
 */
class FilesystemPlugin implements DependencyProviderInterface, ConfigurableInterface
{
    use PluginConfigurationTrait;

    public function provideDependencies(Container $container): void
    {
        $container->register(FilesystemFacadeInterface::class, fn (): FilesystemFacadeInterface => $this->createFacade());
    }

    /**
     * @return FilesystemFacadeInterface
     */
    protected function createFacade(): FilesystemFacadeInterface
    {
        return new FilesystemFacade();
    }
}
