<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\ConfigurationHelper\Business\Path;

use Micro\Plugin\ConfigurationHelper\Business\Plugin\PluginClassResolverInterface;

readonly class PathResolver implements PathResolverInterface
{
    public function __construct(
        private PluginClassResolverInterface $pluginClassResolver
    ) {
    }

    public function resolve(string $relative): string
    {
        if (!str_starts_with($relative, '@')) {
            return $relative;
        }

        $alias = explode(\DIRECTORY_SEPARATOR, $relative);

        $plugin = $this->pluginClassResolver->resolve(ltrim($alias[0], '@'));
        $reflection = new \ReflectionClass($plugin);

        $file = $reflection->getFileName();
        if (false === $file) {
            return $relative;
        }

        $basePath = \dirname($file);
        $alias[0] = $basePath;

        return implode(\DIRECTORY_SEPARATOR, $alias);
    }
}
