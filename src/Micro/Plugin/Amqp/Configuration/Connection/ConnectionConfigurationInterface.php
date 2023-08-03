<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Configuration\Connection;

interface ConnectionConfigurationInterface
{
    public function getHost(): string;

    public function getPort(): int;

    public function getLocale(): string;

    public function getName(): string;

    public function getUsername(): string;

    public function getVirtualHost(): string;

    public function getPassword(): string;

    public function getConnectionTimeout(): float;

    public function getReadWriteTimeout(): float;

    public function getRpcTimeout(): float;

    /**
     * Get authentication method.
     * RabbitMQ supports multiple SASL authentication mechanisms.
     * There are three such mechanisms built into the server: PLAIN, AMQPLAIN, and RABBIT-CR-DEMO, and one — EXTERNAL — available as a plugin.
     *
     * @@see(https://www.rabbitmq.com/access-control.html#mechanisms)
     */
    public function getSaslMethod(): string;

    /**
     * Get path to the CA cert file in PEM format.
     */
    public function getCaCert(): ?string;

    /**
     * Get path to the client certificate in PEM format.
     */
    public function getCert(): ?string;

    /**
     * Get path to the client key in PEM format.
     */
    public function getKey(): ?string;

    public function isVerify(): bool;

    public function keepAlive(): bool;

    public function sslEnabled(): bool;

    public function getSslProtocol(): string;

    /**
     * @throws \InvalidArgumentException
     */
    public function validateSslConfiguration(): void;
}
