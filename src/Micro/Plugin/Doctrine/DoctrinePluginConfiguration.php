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

namespace Micro\Plugin\Doctrine;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\Doctrine\Configuration\EntityManagerConfiguration;
use Micro\Plugin\Doctrine\Configuration\EntityManagerConfigurationInterface;

class DoctrinePluginConfiguration extends PluginConfiguration implements DoctrinePluginConfigurationInterface
{
    public const CFG_CONNECTIONS = 'ORM_CONNECTION_LIST';

    /**
     * {@inheritDoc}
     */
    public function getConnectionList(): array
    {
        return $this->explodeStringToArray(
            $this->configuration->get(self::CFG_CONNECTIONS, self::MANAGER_DEFAULT)
        );
    }

    public function getManagerConfiguration(string $connectionName): EntityManagerConfigurationInterface
    {
        return new EntityManagerConfiguration($this->configuration, $connectionName);
    }

    public function isDevMode(): bool
    {
        return str_starts_with((string) $this->configuration->get('APP_ENV', 'dev'), 'dev');
    }
}
