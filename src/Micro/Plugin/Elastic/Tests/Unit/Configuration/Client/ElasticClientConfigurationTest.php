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

namespace Micro\Plugin\Elastic\Tests\Unit\Configuration\Client;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\Elastic\Configuration\Client\ElasticClientConfigurationInterface;
use Micro\Plugin\Elastic\ElasticPluginConfiguration;
use PHPUnit\Framework\TestCase;

class ElasticClientConfigurationTest extends TestCase
{
    public function testDefaults(): void
    {
        $clientCfg = $this->createConfiguration([]);

        $this->assertTrue($clientCfg->getRetries() > -1);
        $this->assertEquals('default', $clientCfg->getLoggerName());
        $this->assertNull($clientCfg->getApiKey());
        $this->assertNull($clientCfg->getCABundle());
        $this->assertEquals('', $clientCfg->getBasicAuthLogin());
        $this->assertEquals('', $clientCfg->getBasicAuthPassword());
        $this->assertEquals(['localhost:9200'], $clientCfg->getHosts());
        $this->assertNull($clientCfg->getElasticCloudId());
        $this->assertNull($clientCfg->getSslKey());
        $this->assertNull($clientCfg->getSslKeyPassword());
        $this->assertTrue($clientCfg->getSslVerification());
    }

    public function testOverride(): void
    {
        $clientCfg = $this->createConfiguration([
            'APP_ENV' => 'dev-test',
            'MICRO_ELASTIC_TEST_HOSTS' => 'test1,test2',
            'MICRO_ELASTIC_TEST_LOGGER' => 'test-logger',
            'MICRO_ELASTIC_TEST_RETRIES' => 2,
            'MICRO_ELASTIC_TEST_SSL_VERIFY' => false,
            'MICRO_ELASTIC_TEST_SSL_KEY' => 'test-key',
            'MICRO_ELASTIC_TEST_SSL_KEY_PASSWORD' => 'test-ssl-passwd',
            'MICRO_ELASTIC_TEST_API_KEY' => 'test-api-key',
            'MICRO_ELASTIC_TEST_AUTH_BASIC_LOGIN' => 'test-login',
            'MICRO_ELASTIC_TEST_AUTH_BASIC_PASSWORD' => 'test-password',
            'MICRO_ELASTIC_TEST_CLOUD_ID' => 'test-cloud-id',
            'MICRO_ELASTIC_TEST_CA_BUNDLE' => 'test-ca-bundle',
        ]);

        $this->assertEquals(2, $clientCfg->getRetries());
        $this->assertEquals('test-logger', $clientCfg->getLoggerName());
        $this->assertEquals('test-api-key', $clientCfg->getApiKey());
        $this->assertEquals('test-ca-bundle', $clientCfg->getCABundle());
        $this->assertEquals('test-login', $clientCfg->getBasicAuthLogin());
        $this->assertEquals('test-password', $clientCfg->getBasicAuthPassword());
        $this->assertEquals(['test1', 'test2'], $clientCfg->getHosts());
        $this->assertEquals('test-cloud-id', $clientCfg->getElasticCloudId());
        $this->assertEquals('test-key', $clientCfg->getSslKey());
        $this->assertEquals('test-ssl-passwd', $clientCfg->getSslKeyPassword());
        $this->assertFalse($clientCfg->getSslVerification());
    }

    protected function createConfiguration(array $config): ElasticClientConfigurationInterface
    {
        $appCfg = new DefaultApplicationConfiguration($config);
        $pluginConfiguration = new ElasticPluginConfiguration($appCfg);

        return $pluginConfiguration->getClientConfiguration('test');
    }
}
