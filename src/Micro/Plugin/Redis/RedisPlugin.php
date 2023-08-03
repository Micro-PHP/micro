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

namespace Micro\Plugin\Redis;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Plugin\Redis\Business\Redis\RedisFactory;
use Micro\Plugin\Redis\Business\Redis\RedisFactoryInterface;
use Micro\Plugin\Redis\Business\Redis\RedisManager;
use Micro\Plugin\Redis\Business\Redis\RedisManagerInterface;
use Micro\Plugin\Redis\Facade\RedisFacade;
use Micro\Plugin\Redis\Facade\RedisFacadeInterface;

/**
 * @method RedisPluginConfigurationInterface configuration()
 */
class RedisPlugin implements DependencyProviderInterface, ConfigurableInterface
{
    use PluginConfigurationTrait;

    public function provideDependencies(Container $container): void
    {
        $container->register(RedisFacadeInterface::class, function (): Facade\RedisFacadeInterface {
            return $this->createRedisFacade();
        });

        $container->register(RedisFacadeInterface::class, function (Container $container) {
            return $container->get(RedisFacadeInterface::class);
        });
    }

    protected function createRedisFacade(): Facade\RedisFacadeInterface
    {
        return new RedisFacade($this->createRedisManager());
    }

    protected function createRedisManager(): RedisManagerInterface
    {
        return new RedisManager($this->createRedisFactory(), $this->configuration());
    }

    protected function createRedisFactory(): RedisFactoryInterface
    {
        return new RedisFactory();
    }
}
