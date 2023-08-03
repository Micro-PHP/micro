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

namespace Micro\Plugin\Redis\Configuration;

use Micro\Framework\BootConfiguration\Configuration\Exception\InvalidConfigurationException;
use Micro\Framework\BootConfiguration\Configuration\PluginRoutingKeyConfiguration;

class RedisClientConfiguration extends PluginRoutingKeyConfiguration implements RedisClientConfigurationInterface
{
    public const CONNECTION_TYPE_DEFAULT = RedisClientConfigurationInterface::CONNECTION_TYPE_NET;
    public const HOST_DEFAULT = 'localhost';
    public const PORT_DEFAULT = 6379;
    public const CONNECTION_TIMEOUT_DEFAULT = 0.0;
    public const READ_TIMEOUT_DEFAULT = 0.0;
    public const CONNECTION_RETRY_INTERNAL_DEFAULT = 0;
    public const CONNECTION_REUSE_DEFAULT = false;

    protected const CFG_CONNECTION_TYPE = 'REDIS_%s_CONNECTION_TYPE';
    protected const CFG_CONNECTION_REUSE = 'REDIS_%s_CONNECTION_REUSE';
    protected const CFG_CONNECTION_HOST = 'REDIS_%s_HOST';
    protected const CFG_CONNECTION_PORT = 'REDIS_%s_PORT';
    protected const CFG_CONNECTION_TIMEOUT = 'REDIS_%s_TIMEOUT';
    protected const CFG_CONNECTION_RETRY_INTERVAL = 'REDIS_%s_RETRY_INTERVAL';
    protected const CFG_READ_TIMEOUT = 'REDIS_%s_READ_TIMEOUT';

    /**
     * {@inheritDoc}
     */
    public function name(): string
    {
        return $this->configRoutingKey;
    }

    /**
     * {@inheritDoc}
     */
    public function reuseConnection(): bool
    {
        return $this->get(self::CFG_CONNECTION_REUSE, self::CONNECTION_REUSE_DEFAULT);
    }

    /**
     * {@inheritDoc}
     */
    public function connectionType(): string
    {
        $connectionType = $this->get(self::CFG_CONNECTION_TYPE, self::CONNECTION_TYPE_DEFAULT);
        if (!\in_array($connectionType, $this->getAvailableConnectionTypes(), true)) {
            throw new InvalidConfigurationException(sprintf('Configuration key "%s" has invalid value. Redis: connection type %s is not available', $this->cfg(self::CFG_CONNECTION_TYPE), $connectionType));
        }

        return $connectionType;
    }

    /**
     * {@inheritDoc}
     */
    public function host(): string
    {
        return $this->get(self::CFG_CONNECTION_HOST, self::HOST_DEFAULT);
    }

    /**
     * {@inheritDoc}
     */
    public function port(): int
    {
        return (int) $this->get(self::CFG_CONNECTION_PORT, self::PORT_DEFAULT);
    }

    /**
     * {@inheritDoc}
     */
    public function connectionTimeout(): float
    {
        return (float) $this->get(self::CFG_CONNECTION_TIMEOUT, self::CONNECTION_TIMEOUT_DEFAULT);
    }

    public function readTimeout(): float
    {
        return (float) $this->get(self::CFG_READ_TIMEOUT, self::READ_TIMEOUT_DEFAULT);
    }

    /**
     * {@inheritDoc}
     */
    public function sslConfiguration(): SslConfigurationInterface
    {
        return new SslConfiguration($this->configuration, $this->configRoutingKey);
    }

    /**
     * {@inheritDoc}
     */
    public function authorizationConfiguration(): AuthorizationConfigurationInterface
    {
        return new AuthorizationConfiguration($this->configuration, $this->configRoutingKey);
    }

    /**
     * {@inheritDoc}
     */
    public function clientOptionsConfiguration(): ClientOptionsConfigurationInterface
    {
        return new ClientOptionsConfiguration($this->configuration, $this->configRoutingKey);
    }

    /**
     * {@inheritDoc}
     */
    public function retryInterval(): int
    {
        return (int) $this->get(self::CFG_CONNECTION_RETRY_INTERVAL, self::CONNECTION_RETRY_INTERNAL_DEFAULT);
    }

    /**
     * @return string[]
     */
    protected function getAvailableConnectionTypes(): array
    {
        return [
            RedisClientConfigurationInterface::CONNECTION_TYPE_NET,
            RedisClientConfigurationInterface::CONNECTION_TYPE_UNIX,
        ];
    }
}
