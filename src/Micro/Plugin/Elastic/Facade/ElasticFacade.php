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

namespace Micro\Plugin\Elastic\Facade;

use Elastic\Elasticsearch\ClientInterface;
use Micro\Plugin\Elastic\Client\Factory\ElasticClientFactoryInterface;
use Micro\Plugin\Elastic\Configuration\ElasticPluginConfigurationInterface;

readonly class ElasticFacade implements ElasticFacadeInterface
{
    /**
     * @param ElasticClientFactoryInterface $elasticClientFactory
     */
    public function __construct(
        private ElasticClientFactoryInterface $elasticClientFactory
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function createClient(string $clientName = ElasticPluginConfigurationInterface::CLIENT_DEFAULT): ClientInterface
    {
        return $this->elasticClientFactory->create($clientName);
    }
}
