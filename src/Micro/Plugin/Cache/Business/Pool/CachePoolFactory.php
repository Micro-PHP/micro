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

readonly class CachePoolFactory implements CachePoolFactoryInterface
{
    public function __construct(
        private AdapterFactoryInterface $adapterFactory
    ) {
    }

    public function create(): CachePoolInterface
    {
        return new CachePool(
            $this->adapterFactory
        );
    }
}
