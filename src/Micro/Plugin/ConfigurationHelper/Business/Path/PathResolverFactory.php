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

readonly class PathResolverFactory implements PathResolverFactoryInterface
{
    public function __construct(
        private PluginClassResolverInterface $pluginClassResolver
    ) {
    }

    public function create(): PathResolverInterface
    {
        return new PathResolverCacheDecorator(
            new PathResolver($this->pluginClassResolver)
        );
    }
}
