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

namespace Micro\Plugin\Doctrine\Configuration;

use Doctrine\DBAL\DriverManager;
use Micro\Framework\BootConfiguration\Configuration\PluginRoutingKeyConfiguration;
use Micro\Plugin\Doctrine\Configuration\Driver\DriverConfigurationInterface;
use Micro\Plugin\Doctrine\Configuration\Driver\PdoMySqlConfiguration;
use Micro\Plugin\Doctrine\Configuration\Driver\PdoPgSqlConfiguration;
use Micro\Plugin\Doctrine\Configuration\Driver\PdoSqliteDriverConfiguration;

class EntityManagerConfiguration extends PluginRoutingKeyConfiguration implements EntityManagerConfigurationInterface
{
    /**
     * Driver name.
     *
     * Example `ORM_DEFAULT_DRIVER=pdo_mysql`
     *
     * @api
     */
    public const CFG_DRIVER_NAME = 'ORM_%s_DRIVER';

    /**
     * Driver name.
     *
     * Example `ORM_DEFAULT_PROXY_DIR=${BASE_PATH}/var/cache/orm/proxy`
     *
     * @api
     */
    public const CFG_PROXY_DIR = 'ORM_%s_PROXY_DIR';

    /**
     * @return string|null
     */
    public function getProxyDir(): ?string
    {
        return $this->get(self::CFG_PROXY_DIR);
    }

    public function getDriverName(): string
    {
        return $this->get(self::CFG_DRIVER_NAME, null, false);
    }

    public function getDriverConfiguration(): DriverConfigurationInterface
    {
        $driverName = mb_strtolower($this->getDriverName());

        if (!\in_array($driverName, $this->getAvailableDrivers())) {
            throw new \InvalidArgumentException(sprintf('ORM: Driver `%s` is not supported.', $driverName));
        }

        return match ($driverName) {
            PdoMySqlConfiguration::name() => new PdoMySqlConfiguration($this->configuration, $this->configRoutingKey),
            PdoPgSqlConfiguration::name() => new PdoPgSqlConfiguration($this->configuration, $this->configRoutingKey),
            PdoSqliteDriverConfiguration::name() => new PdoSqliteDriverConfiguration($this->configuration, $this->configRoutingKey),
            default => throw new \InvalidArgumentException(sprintf('Driver `%s` is available, but not supported in the current version.', $driverName)),
        };
    }

    /**
     * @return string[]
     */
    public function getAvailableDrivers(): array
    {
        return DriverManager::getAvailableDrivers();
    }
}
