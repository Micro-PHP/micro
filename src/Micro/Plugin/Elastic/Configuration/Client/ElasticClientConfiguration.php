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

namespace Micro\Plugin\Elastic\Configuration\Client;

use Micro\Framework\BootConfiguration\Configuration\PluginRoutingKeyConfiguration;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;

class ElasticClientConfiguration extends PluginRoutingKeyConfiguration implements ElasticClientConfigurationInterface
{
    public const CFG_CLIENT_HOSTS = 'MICRO_ELASTIC_%s_HOSTS';
    public const CFG_CLIENT_LOGGER = 'MICRO_ELASTIC_%s_LOGGER';
    public const CFG_CLIENT_RETRIES = 'MICRO_ELASTIC_%s_RETRIES';
    public const CFG_CLIENT_SSL_VERIFY = 'MICRO_ELASTIC_%s_SSL_VERIFY';
    public const CFG_CLIENT_SSL_KEY = 'MICRO_ELASTIC_%s_SSL_KEY';
    public const CFG_CLIENT_SSL_KEY_PWD = 'MICRO_ELASTIC_%s_SSL_KEY_PASSWORD';
    public const CFG_CLIENT_API_KEY = 'MICRO_ELASTIC_%s_API_KEY';
    public const CFG_CLIENT_BA_LOGIN = 'MICRO_ELASTIC_%s_AUTH_BASIC_LOGIN';
    public const CFG_CLIENT_BA_PWD = 'MICRO_ELASTIC_%s_AUTH_BASIC_PASSWORD';
    public const CFG_CLIENT_CLOUD_ID = 'MICRO_ELASTIC_%s_CLOUD_ID';
    public const CFG_CLIENT_CA_BUNDLE = 'MICRO_ELASTIC_%s_CA_BUNDLE';

    /**
     * {@inheritDoc}
     */
    public function getHosts(): array
    {
        $hosts = $this->get(self::CFG_CLIENT_HOSTS, 'localhost:9200', false);

        return $this->explodeStringToArray($hosts);
    }

    /**
     * {@inheritDoc}
     */
    public function getLoggerName(): string
    {
        return $this->get(self::CFG_CLIENT_LOGGER, LoggerFacadeInterface::LOGGER_DEFAULT, false);
    }

    /**
     * {@inheritDoc}
     */
    public function getRetries(): int
    {
        return (int) $this->get(self::CFG_CLIENT_RETRIES, 1, false);
    }

    /**
     * {@inheritDoc}
     */
    public function getSslVerification(): bool
    {
        return (bool) $this->get(self::CFG_CLIENT_SSL_VERIFY, true, false);
    }

    /**
     * {@inheritDoc}
     */
    public function getSslKey(): string|null
    {
        return $this->get(self::CFG_CLIENT_SSL_KEY);
    }

    /**
     * {@inheritDoc}
     */
    public function getSslKeyPassword(): string|null
    {
        return $this->get(self::CFG_CLIENT_SSL_KEY_PWD);
    }

    /**
     * {@inheritDoc}
     */
    public function getApiKey(): string|null
    {
        return $this->get(self::CFG_CLIENT_API_KEY);
    }

    /**
     * {@inheritDoc}
     */
    public function getBasicAuthLogin(): string
    {
        return (string) $this->get(self::CFG_CLIENT_BA_LOGIN);
    }

    /**
     * {@inheritDoc}
     */
    public function getBasicAuthPassword(): string
    {
        return (string) $this->get(self::CFG_CLIENT_BA_PWD);
    }

    /**
     * {@inheritDoc}
     */
    public function getElasticCloudId(): string|null
    {
        return $this->get(self::CFG_CLIENT_CLOUD_ID);
    }

    /**
     * {@inheritDoc}
     */
    public function getCABundle(): string|null
    {
        return $this->get(self::CFG_CLIENT_CA_BUNDLE);
    }
}
