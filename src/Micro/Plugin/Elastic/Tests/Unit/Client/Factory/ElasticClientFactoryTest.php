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

namespace Micro\Plugin\Elastic\Tests\Unit\Client\Factory;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\Elastic\Client\Factory\ElasticClientFactory;
use Micro\Plugin\Elastic\Client\Factory\ElasticClientFactoryInterface;
use Micro\Plugin\Elastic\Configuration\ElasticPluginConfigurationInterface;
use Micro\Plugin\Elastic\ElasticPluginConfiguration;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;
use PHPUnit\Framework\TestCase;

class ElasticClientFactoryTest extends TestCase
{
    private ApplicationConfigurationInterface $applicationConfiguration;
    private ElasticPluginConfigurationInterface $pluginConfiguration;

    private LoggerFacadeInterface $loggerFacade;

    private ElasticClientFactory $clientFactory;

    protected function setUp(): void
    {
        $this->loggerFacade = $this->createMock(LoggerFacadeInterface::class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSimpleCreateClient(array $configuration): void
    {
        $factory = $this->createElasticClientFactory($configuration);

        $result = $factory->create('test');

        var_dump($result);

        $this->assertTrue(true);
    }

    public static function dataProvider(): array
    {
        return [
            [
                [
                    'APP_ENV' => 'dev-test',
                    'MICRO_ELASTIC_TEST_HOSTS' => 'localhost',
                    'MICRO_ELASTIC_TEST_LOGGER' => 'default',
                    'MICRO_ELASTIC_TEST_RETRIES' => 2,
                    'MICRO_ELASTIC_TEST_SSL_VERIFY' => true,
                    'MICRO_ELASTIC_TEST_SSL_KEY' => 'test-key',
                    'MICRO_ELASTIC_TEST_SSL_KEY_PASSWORD' => 'test-passwd',
                    // 'MICRO_ELASTIC_TEST_API_KEY' => 'test-api-key',
                    'MICRO_ELASTIC_TEST_AUTH_BASIC_LOGIN' => 'test-login',
                    'MICRO_ELASTIC_TEST_AUTH_BASIC_PASSWORD' => 'test-password',
                    // 'MICRO_ELASTIC_TEST_CLOUD_ID' => 'test-cloud-id',
                    'MICRO_ELASTIC_TEST_CA_BUNDLE' => 'test-ca-bundle',
                ],
            ],
        ];
    }

    protected function createElasticClientFactory(array $configuration): ElasticClientFactoryInterface
    {
        $appConfig = new DefaultApplicationConfiguration($configuration);

        $pluginConfig = new ElasticPluginConfiguration($appConfig);

        return new ElasticClientFactory($pluginConfig, $this->loggerFacade);
    }
}
