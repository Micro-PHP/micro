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

namespace Micro\Plugin\Doctrine\Tests\Unit\Configuration\Driver;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\Doctrine\Configuration\Driver\DriverConfigurationInterface;
use Micro\Plugin\Doctrine\Configuration\Driver\PdoMySqlConfiguration;
use Micro\Plugin\Doctrine\Configuration\Driver\PdoPgSqlConfiguration;
use Micro\Plugin\Doctrine\Configuration\Driver\PdoSqliteDriverConfiguration;
use PHPUnit\Framework\TestCase;

class DriverConfigurationInterfaceTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testDrivers(string $adapterClass, array $adapterConfig, array $toArrayExcepted)
    {
        $arrayCfg = [];
        foreach ($adapterConfig as $cfgName => $cfgValue) {
            $arrayCfg['ORM_TEST_'.mb_strtoupper($cfgName)] = $cfgValue;
        }

        $appCfg = new DefaultApplicationConfiguration($arrayCfg);

        /** @var DriverConfigurationInterface $cfg */
        $cfg = new $adapterClass(
            $appCfg,
            'test'
        );

        $this->assertInstanceOf(DriverConfigurationInterface::class, $cfg);
        $this->assertEquals($toArrayExcepted, $cfg->getParameters());
    }

    public function dataProvider()
    {
        $user = 'demo0';
        $password = 'pwd';
        $db = 'test';
        $port = '555';
        $host = 'somehost';
        $path = '/dev/null';

        return [
            [
                PdoMySqlConfiguration::class,
                [
                    'host' => $host,
                    'port' => $port,
                    'DATABASE' => $db,
                    'user' => $user,
                    'password' => $password,
                ],
                [
                    'driver' => 'pdo_mysql',
                    'user' => $user,
                    'host' => $host,
                    'password' => $password,
                    'port' => (int) $port,
                    'dbname' => $db,
                ],
            ],
            [
                PdoPgSqlConfiguration::class,
                [
                    'host' => $host,
                    'port' => $port,
                    'DATABASE' => $db,
                    'user' => $user,
                    'password' => $password,
                ],
                [
                    'driver' => 'pdo_pgsql',
                    'user' => $user,
                    'host' => $host,
                    'password' => $password,
                    'port' => (int) $port,
                    'dbname' => $db,
                ],
            ],
            [
                PdoSqliteDriverConfiguration::class,
                [
                    'path' => $path,
                    'in_memory' => false,
                    'user' => $user,
                    'password' => $password,
                ],
                [
                    'driver' => 'pdo_sqlite',
                    'path' => $path,
                    'user' => $user,
                    'password' => $password,
                    'memory' => false,
                ],
            ],
            [
                PdoSqliteDriverConfiguration::class,
                [
                    'path' => $path,
                    'in_memory' => true,
                    'user' => $user,
                    'password' => $password,
                ],
                [
                    'driver' => 'pdo_sqlite',
                    'user' => $user,
                    'password' => $password,
                    'memory' => true,
                ],
            ],
        ];
    }
}
