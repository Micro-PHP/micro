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

namespace Micro\Plugin\Cache\Tests\Unit;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Framework\BootConfiguration\Configuration\Exception\InvalidConfigurationException;
use Micro\Plugin\Redis\RedisPluginConfiguration;
use PHPUnit\Framework\TestCase;

class RedisPluginConfigurationTest extends TestCase
{
    private RedisPluginConfiguration $cfg;

    protected function setUp(): void
    {
        /*
         * protected const CFG_CONNECTION_HOST = 'REDIS_%s_HOST';
    protected const CFG_CONNECTION_PORT = 'REDIS_%s_PORT';
    protected const CFG_CONNECTION_TIMEOUT = 'REDIS_%s_TIMEOUT';
    protected const CFG_CONNECTION_RETRY_INTERVAL = 'REDIS_%s_RETRY_INTERVAL';
    protected const CFG_READ_TIMEOUT = 'REDIS_%s_READ_TIMEOUT';
         */
        $appCfg = new DefaultApplicationConfiguration([
            'REDIS_INVALID_CONNECTION_TYPE' => 'invalid',
            'REDIS_TEST_CONNECTION_TYPE' => 'unix',
            'REDIS_TEST_CONNECTION_REUSE' => true,
            'REDIS_TEST_HOST' => '1',
            'REDIS_TEST_PORT' => 2,
            'REDIS_TEST_TIMEOUT' => 3,
            'REDIS_TEST_RETRY_INTERVAL' => 4,
            'REDIS_TEST_READ_TIMEOUT' => 5,
            'REDIS_TEST_AUTH_USERNAME' => 'user',
            'REDIS_TEST_AUTH_PASSWORD' => 'password',
            'REDIS_TEST_SSL_ENABLED' => 'On',
            'REDIS_TEST_SSL_VERIFY' => 'On',
            'REDIS_TEST_OPT_SERIALIZER' => 'none',
            'REDIS_TEST_OPT_PREFIX' => 'prefix',
            'REDIS_TEST_OPT_SCAN' => 'scan',
        ]);
        $this->cfg = new RedisPluginConfiguration($appCfg);
    }

    public function testInvalidConnectionType(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $clientCfg = $this->cfg->getClientConfiguration('invalid');
        $clientCfg->connectionType();
    }

    public function testConfiguration(): void
    {
        $clientCfg = $this->cfg->getClientConfiguration('test');

        $this->assertEquals('test', $clientCfg->name());
        $this->assertEquals(2, $clientCfg->port());
        $this->assertEquals('1', $clientCfg->host());
        $this->assertEquals(3., $clientCfg->connectionTimeout());
        $this->assertEquals(5, $clientCfg->readTimeout());
        $this->assertEquals(4, $clientCfg->retryInterval());
        $this->assertTrue($clientCfg->reuseConnection());

        $opts = $clientCfg->clientOptionsConfiguration();
        $this->assertEquals('prefix', $opts->prefix());
        $this->assertEquals('scan', $opts->scan());
        $this->assertEquals('none', $opts->serializer());

        $auth = $clientCfg->authorizationConfiguration();
        $this->assertEquals('password', $auth->password());
        $this->assertEquals('user', $auth->username());

        $ssl = $clientCfg->sslConfiguration();
        $this->assertTrue($ssl->enabled());
        $this->assertTrue($ssl->verify());
    }

    public function testDefaultConfiguration()
    {
        $clientCfg = $this->cfg->getClientConfiguration('default');

        $this->assertEquals('default', $clientCfg->name());
        $this->assertEquals(6379, $clientCfg->port());
        $this->assertEquals('localhost', $clientCfg->host());
        $this->assertEquals(0.0, $clientCfg->connectionTimeout());
        $this->assertEquals(0, $clientCfg->readTimeout());
        $this->assertEquals(0, $clientCfg->retryInterval());
        $this->assertFalse($clientCfg->reuseConnection());
        $this->assertEquals('network', $clientCfg->connectionType());

        $opts = $clientCfg->clientOptionsConfiguration();
        $this->assertEquals('', $opts->prefix());
        $this->assertEquals('', $opts->scan());
        $this->assertEquals('SERIALIZER_NONE', $opts->serializer());

        $auth = $clientCfg->authorizationConfiguration();
        $this->assertNull($auth->password());
        $this->assertNull($auth->username());

        $ssl = $clientCfg->sslConfiguration();
        $this->assertFalse($ssl->enabled());
        $this->assertFalse($ssl->verify());
    }
}
