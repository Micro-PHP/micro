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

namespace Micro\Plugin\Doctrine\Configuration\Driver;

use Micro\Framework\BootConfiguration\Configuration\PluginRoutingKeyConfiguration;

class PdoMySqlConfiguration extends PluginRoutingKeyConfiguration implements DriverConfigurationInterface
{
    use HostPortDbTrait;
    use UserPasswordTrait;

    public function getParameters(): array
    {
        return [
            'driver' => static::name(),
            'user' => $this->getUser(),
            'host' => $this->getHost(),
            'password' => $this->getPassword(),
            'port' => $this->getPort(3306),
            'dbname' => $this->getDb(),
        ];
    }

    public static function name(): string
    {
        return 'pdo_mysql';
    }
}
