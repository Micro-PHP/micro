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
use Micro\Framework\DependencyInjection\Exception\ServiceNotRegisteredException;
use Micro\Plugin\Cache\Business\Adapter\ConcreteAdapterFactoryInterface;
use Micro\Plugin\Cache\Configuration\Adapter\CachePoolConfigurationInterface;
use Micro\Plugin\Redis\Facade\RedisFacadeInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Exception\CacheException;

readonly class RedisFactory implements ConcreteAdapterFactoryInterface
{
    public function __construct(private Container $container)
    {
    }

    public function create(CachePoolConfigurationInterface $configuration): CacheItemPoolInterface
    {
        if (!\extension_loaded('redis')) {
            throw new CacheException('Extension `redis` should be installed.');
        }

        try {
            /** @var \Redis $redis */
            $redis = $this->container->get(RedisFacadeInterface::class)->getClient($configuration->getConnectionName());
        } catch (ServiceNotRegisteredException $exception) {
            throw new CacheException('Plugin `micro/plugin-redis` should be installed.', 0, $exception);
        }

        // TODO: Marshaller
        return new RedisAdapter(
            $redis,
            $configuration->getNamespace(),
            $configuration->getDefaultLifetime(),
        );
    }

    public function type(): string
    {
        return 'redis';
    }
}
