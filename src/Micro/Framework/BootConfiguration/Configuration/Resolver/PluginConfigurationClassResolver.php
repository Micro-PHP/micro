<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\BootConfiguration\Configuration\Resolver;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Framework\BootConfiguration\Configuration\PluginConfigurationInterface;

readonly class PluginConfigurationClassResolver
{
    public function __construct(
        private ApplicationConfigurationInterface $applicationConfiguration
    ) {
    }

    public function resolve(string $pluginClass): PluginConfigurationInterface
    {
        $configClassDefault = PluginConfiguration::class;
        $configClasses = [];
        foreach ($this->getPluginClassResolvers() as $resolver) {
            $configClass = $resolver->resolve($pluginClass);
            if (!class_exists($configClass)) {
                continue;
            }

            $configClasses[] = $configClass;
        }

        if (\count($configClasses) > 1) {
            throw new \RuntimeException(sprintf('Too many configuration classes for Application plugin "%s". [%s]', $pluginClass, implode(', ', $configClasses)));
        }

        /** @var class-string<PluginConfigurationInterface> $configClass */
        $configClass = $configClasses[0] ?? $configClassDefault;

        return new $configClass($this->applicationConfiguration);
    }

    /**
     * @return PluginConfigurationClassResolverInterface[]
     */
    protected function getPluginClassResolvers(): array
    {
        return [
            new PluginNameResolver(),
            new PluginNameShortResolver(),
        ];
    }
}
