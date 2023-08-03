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

use Micro\Framework\DependencyInjection\Container;
use Micro\Plugin\Cache\Business\Adapter\ConcreteAdapterFactoryInterface;
use Micro\Plugin\Cache\Configuration\Adapter\CachePoolConfigurationInterface;
use Micro\Plugin\Doctrine\DoctrineFacadeInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\PdoAdapter;
use Symfony\Component\Cache\Exception\CacheException;

readonly class PdoFactory implements ConcreteAdapterFactoryInterface
{
    public function __construct(private Container $container)
    {
    }

    public function create(CachePoolConfigurationInterface $configuration): CacheItemPoolInterface
    {
        if (!\extension_loaded('pdo')) {
            throw new CacheException('Extension `pdo` should be installed.');
        }

        $manager = $this->container->get(DoctrineFacadeInterface::class)->getManager($configuration->getConnectionName());
        $connection = $manager->getConnection()->getNativeConnection();

        if (!($connection instanceof \PDO)) {
            throw new CacheException(sprintf('Entity manager connection should be instance of `%s`', \PDO::class));
        }

        return new PdoAdapter(
            $connection,
            $configuration->getNamespace(),
            $configuration->getDefaultLifetime(),
        );
    }

    public function type(): string
    {
        return 'doctrine';
    }
}
