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

namespace Micro\Plugin\Cache\Facade;

use Micro\Plugin\Cache\Business\Pool\CachePoolFactoryInterface;
use Micro\Plugin\Cache\Business\Pool\CachePoolInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\AbstractAdapter;

class CacheFacade implements CacheFacadeInterface
{
    private CachePoolInterface|null $cachePool;

    public function __construct(
        private readonly CachePoolFactoryInterface $cachePoolFactory
    ) {
        $this->cachePool = null;
    }

    public function getCachePsr6(string $cachePoolName): CacheItemPoolInterface
    {
        return $this->getCachePool()->getCachePsr6($cachePoolName);
    }

    public function getCachePsr16(string $cachePoolName): CacheItemPoolInterface
    {
        return $this->getCachePool()->getCachePsr16($cachePoolName);
    }

    public function getCacheSymfony(string $cachePoolName): AbstractAdapter
    {
        return $this->getCachePool()->getCacheSymfony($cachePoolName);
    }

    protected function getCachePool(): CachePoolInterface
    {
        if ($this->cachePool) {
            return $this->cachePool;
        }

        $this->cachePool = $this->cachePoolFactory->create();

        return $this->cachePool;
    }
}
