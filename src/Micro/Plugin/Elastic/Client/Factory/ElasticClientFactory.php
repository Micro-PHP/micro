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

namespace Micro\Plugin\Elastic\Client\Factory;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\ClientInterface;
use Micro\Plugin\Elastic\Configuration\ElasticPluginConfigurationInterface;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;

readonly class ElasticClientFactory implements ElasticClientFactoryInterface
{
    /**
     * @param ElasticPluginConfigurationInterface $pluginConfiguration
     * @param LoggerFacadeInterface               $loggerFacade
     */
    public function __construct(
        private ElasticPluginConfigurationInterface $pluginConfiguration,
        private LoggerFacadeInterface $loggerFacade
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function create(string $clientName): ClientInterface
    {
        $clientConfiguration = $this->pluginConfiguration->getClientConfiguration($clientName);
        $builder = ClientBuilder::create()->setHosts($clientConfiguration->getHosts());

        $basicLogin = $clientConfiguration->getBasicAuthLogin();
        if (!empty($basicLogin)) {
            $builder->setBasicAuthentication($basicLogin, $clientConfiguration->getBasicAuthPassword());
        }

        $apiKey = $clientConfiguration->getApiKey();
        if ($apiKey) {
            $builder->setApiKey($apiKey);
        }

        $elasticCloudId = $clientConfiguration->getElasticCloudId();
        if ($elasticCloudId) {
            $builder->setElasticCloudId($elasticCloudId);
        }

        $logger = $this->loggerFacade->getLogger($clientConfiguration->getLoggerName());

        $builder->setLogger($logger);
        $builder->setRetries($clientConfiguration->getRetries());
        $builder->setSSLVerification($clientConfiguration->getSslVerification());

        $caBundle = $clientConfiguration->getCABundle();
        if ($caBundle) {
            $builder->setCABundle($caBundle);
        }

        $sslKey = $clientConfiguration->getSslKey();
        if ($sslKey) {
            $builder->setSSLKey($sslKey, $clientConfiguration->getSslKeyPassword());
        }

        return $builder->build();
    }
}
