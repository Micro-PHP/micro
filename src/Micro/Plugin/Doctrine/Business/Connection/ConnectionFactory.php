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

namespace Micro\Plugin\Doctrine\Business\Connection;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Micro\Plugin\Doctrine\DoctrinePluginConfigurationInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class ConnectionFactory implements ConnectionFactoryInterface
{
    public function __construct(private DoctrinePluginConfigurationInterface $pluginConfiguration)
    {
    }

    public function create(string $entityManagerName): Connection
    {
        $emCfg = $this->pluginConfiguration->getManagerConfiguration($entityManagerName);
        $driverCfg = $emCfg->getDriverConfiguration();

        return DriverManager::getConnection(
            $driverCfg->getParameters(),
        );
    }
}
