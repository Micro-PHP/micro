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

use Micro\Plugin\Doctrine\Configuration\EntityManagerConfigurationInterface;

interface DoctrinePluginConfigurationInterface
{
    public const MANAGER_DEFAULT = 'default';

    /**
     * List of compound names. They are also aliases for specific entity managers. By default, ["default"].
     *
     * @api
     *
     * @return string[]
     */
    public function getConnectionList(): array;

    /**
     * Environment variable `APP_ENV` start with 'dev'.
     *
     * @return bool
     */
    public function isDevMode(): bool;

    /**
     * @api
     *
     * @param string $connectionName Entity manager alias
     *
     * @return EntityManagerConfigurationInterface Returns entity manager configuration
     */
    public function getManagerConfiguration(string $connectionName): EntityManagerConfigurationInterface;
}
