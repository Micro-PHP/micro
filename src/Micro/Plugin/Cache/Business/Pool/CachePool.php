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

namespace Micro\Plugin\Cache\Business\Pool;

use Micro\Plugin\Cache\Business\Adapter\AdapterFactoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Cache\Adapter\Psr16Adapter;
use Symfony\Component\Cache\Psr16Cache;

class CachePool implements CachePoolInterface
{
    /**
     * @var array<string, CacheItemPoolInterface>
     */
    private array $cacheItemsCollection;

    public function __construct(
        private readonly AdapterFactoryInterface $adapterFactory
    ) {
        $this->cacheItemsCollection = [];
    }

    public function getCachePsr16(string $cachePoolName): CacheItemPoolInterface
    {
        $cache = new Psr16Cache($this->getCachePsr6($cachePoolName));

        return new Psr16Adapter($cache);
    }

    public function getCachePsr6(string $cachePoolName): CacheItemPoolInterface
    {
        if (\array_key_exists($cachePoolName, $this->cacheItemsCollection)) {
            return $this->cacheItemsCollection[$cachePoolName];
        }

        $item = $this->adapterFactory->create($cachePoolName);

        $this->cacheItemsCollection[$cachePoolName] = $item;

        return $item;
    }

    public function getCacheSymfony(string $cachePoolName): AbstractAdapter
    {
        /** @var AbstractAdapter $item */
        $item = $this->getCachePsr16($cachePoolName);

        return $item;
    }
}
