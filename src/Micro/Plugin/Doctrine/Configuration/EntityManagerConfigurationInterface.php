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

use Micro\Plugin\Doctrine\Configuration\Driver\DriverConfigurationInterface;

interface EntityManagerConfigurationInterface
{
    /**
     * If $isDevMode is true caching is done in memory with the ArrayAdapter. Proxy objects are recreated on every request.
     * If $isDevMode is false, set then proxy classes have to be explicitly created through the command line.
     * If third argument `$proxyDir` is not set, use the systems temporary directory.
     *
     * @api
     */
    public function getProxyDir(): ?string;

    /**
     *  Get entity manager driver.
     *
     * @api
     */
    public function getDriverName(): string;

    /**
     *          Implemented:
     * 'pdo_mysql'
     * 'pdo_sqlite'
     * 'pdo_pgsql'.
     *
     * TODO:
     *      - 'pdo_oci'
     *      -  'oci8'
     *      - 'ibm_db2'
     *      - 'pdo_sqlsrv'
     *      - 'mysqli'
     *      - 'sqlsrv'
     *
     * @api
     */
    public function getDriverConfiguration(): DriverConfigurationInterface;
}
