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

namespace Micro\Plugin\Cache\Business\Adapter\Concrete;

use Micro\Plugin\Cache\Business\Adapter\ConcreteAdapterFactoryInterface;
use Micro\Plugin\Cache\Configuration\Adapter\CachePoolConfigurationInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class FilesystemFactory implements ConcreteAdapterFactoryInterface
{
    public function create(CachePoolConfigurationInterface $configuration): CacheItemPoolInterface
    {
        // TODO: Marshaller
        return new FilesystemAdapter(
            $configuration->getNamespace(),
            $configuration->getDefaultLifetime(),
            $configuration->getDirectory(),
        );
    }

    public function type(): string
    {
        return 'filesystem';
    }
}
