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

namespace Micro\Plugin\Cache\Business\Adapter;

use Micro\Plugin\Cache\Configuration\CachePluginConfigurationInterface;
use Psr\Cache\CacheItemPoolInterface;

readonly class AdapterFactory implements AdapterFactoryInterface
{
    /**
     * @param iterable<ConcreteAdapterFactoryInterface> $cacheConcreteAdapterFactoryCollection
     */
    public function __construct(
        private CachePluginConfigurationInterface $cachePluginConfiguration,
        private iterable $cacheConcreteAdapterFactoryCollection
    ) {
    }

    public function create(string $cachePoolName): CacheItemPoolInterface
    {
        $types = [];
        $configuration = $this->cachePluginConfiguration->getPoolConfiguration($cachePoolName);
        $adapterType = $configuration->getAdapterType();
        foreach ($this->cacheConcreteAdapterFactoryCollection as $factory) {
            $type = $factory->type();
            if ($type === $adapterType) {
                return $factory->create($configuration);
            }
            $types[] = $type;
        }

        $errorMessage = sprintf(
            'Can not initialize cache pool `%s`. Adapter type `%s` is not supported. Available types: %s',
            $cachePoolName,
            $adapterType,
            implode(', ', $types)
        );

        throw new \InvalidArgumentException($errorMessage);
    }
}
