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

use Psr\Cache\CacheException;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\AbstractAdapter;

interface CachePoolInterface
{
    /**
     * @throws CacheException
     */
    public function getCachePsr16(string $cachePoolName): CacheItemPoolInterface;

    /**
     * @throws CacheException
     */
    public function getCachePsr6(string $cachePoolName): CacheItemPoolInterface;

    /**
     * @throws CacheException
     */
    public function getCacheSymfony(string $cachePoolName): AbstractAdapter;
}
