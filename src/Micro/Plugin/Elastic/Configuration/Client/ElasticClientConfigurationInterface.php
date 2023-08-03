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

interface ElasticClientConfigurationInterface
{
    /**
     * Example: localhostL9200,elastic:9200.
     *
     * @return string[]
     */
    public function getHosts(): array;

    /**
     * @return string
     */
    public function getLoggerName(): string;

    /**
     * @return int
     */
    public function getRetries(): int;

    /**
     * @return bool
     */
    public function getSslVerification(): bool;

    /**
     * The name of a file containing a private SSL key.
     *
     * @return string|null
     */
    public function getSslKey(): string|null;

    /**
     * If the private key requires a password.
     *
     * @return string|null
     */
    public function getSslKeyPassword(): string|null;

    /**
     * @return string|null
     */
    public function getApiKey(): string|null;

    /**
     * @return string
     */
    public function getBasicAuthLogin(): string;

    /**
     * @return string
     */
    public function getBasicAuthPassword(): string;

    /**
     * @return string|null
     */
    public function getElasticCloudId(): string|null;

    /**
     * The name of a file containing a PEM formatted certificate.
     *
     * @return string|null
     */
    public function getCABundle(): string|null;
}
