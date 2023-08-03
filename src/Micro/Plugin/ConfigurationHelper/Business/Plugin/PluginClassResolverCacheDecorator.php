<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\ConfigurationHelper\Business\Plugin;

class PluginClassResolverCacheDecorator implements PluginClassResolverInterface
{
    /**
     * @var array<string, object>
     */
    private array $cache;

    public function __construct(
        private readonly PluginClassResolverInterface $pluginClassResolver
    ) {
        $this->cache = [];
    }

    public function resolve(string $pluginAlias): object
    {
        if (\array_key_exists($pluginAlias, $this->cache)) {
            return $this->cache[$pluginAlias];
        }

        $result = $this->pluginClassResolver->resolve($pluginAlias);

        $this->cache[$pluginAlias] = $result;

        return $result;
    }
}
