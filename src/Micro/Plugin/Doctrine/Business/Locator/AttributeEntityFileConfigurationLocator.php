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

namespace Micro\Plugin\Doctrine\Business\Locator;

use Micro\Framework\Kernel\KernelInterface;

readonly class AttributeEntityFileConfigurationLocator implements EntityFileConfigurationLocatorInterface
{
    public function __construct(
        private KernelInterface $kernel
    ) {
    }

    public function getEnabledPluginDirs(): array
    {
        $files = [];

        foreach ($this->kernel->plugins() as $plugin) {
            $pluginFiles = $this->getPluginFiles($plugin);
            if (!$pluginFiles) {
                continue;
            }

            $files[] = $pluginFiles;
        }

        return $files;
    }

    private function getPluginFiles(object $plugin): string|null
    {
        $reflection = new \ReflectionClass($plugin);
        $file = $reflection->getFileName();

        return $file ? \dirname($file) : null;
    }
}
