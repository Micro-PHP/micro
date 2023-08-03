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

namespace Micro\Plugin\Amqp\Tests\Unit\Business\Connection;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\Amqp\Business\Connection\ConnectionBuilder;
use Micro\Plugin\Amqp\Configuration\Connection\ConnectionConfiguration;
use PhpAmqpLib\Exception\AMQPIOException;
use PHPUnit\Framework\TestCase;

class ConnectionBuilderTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testBuilderNoSsl(array $cfgSource, string|null $exceptedException): void
    {
        $appCfg = new DefaultApplicationConfiguration($cfgSource);
        $cfg = new ConnectionConfiguration($appCfg, 'default');

        if ($exceptedException) {
            $this->expectException($exceptedException);
        }

        $connectionBuilder = new ConnectionBuilder();
        $connection = $connectionBuilder->createConnection($cfg);

        $this->assertEquals($cfg->getReadWriteTimeout(), $connection->getReadTimeout());
    }

    public static function dataProvider(): array
    {
        return [
            [
                [
                    'AMQP_CONNECTION_DEFAULT_SSL_ENABLED' => 'true',
                ],
                \InvalidArgumentException::class,
            ],
            [
                [
                    'AMQP_CONNECTION_DEFAULT_SSL_ENABLED' => 'true',
                    'AMQP_CONNECTION_DEFAULT_CERT' => 'abc',
                    'AMQP_CONNECTION_DEFAULT_CA_CERT' => 'def',
                ],
                AMQPIOException::class,
            ],
            [
                [
                    'AMQP_CONNECTION_DEFAULT_SSL_ENABLED' => 'false',
                ],
                AMQPIOException::class,
            ],
        ];
    }
}
