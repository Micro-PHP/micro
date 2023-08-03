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

namespace Micro\Plugin\Elastic;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;
use Micro\Plugin\Elastic\Configuration\Client\ElasticClientConfiguration;
use Micro\Plugin\Elastic\Configuration\Client\ElasticClientConfigurationInterface;
use Micro\Plugin\Elastic\Configuration\ElasticPluginConfigurationInterface;

class ElasticPluginConfiguration extends PluginConfiguration implements ElasticPluginConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getClientConfiguration(string $clientName = self::CLIENT_DEFAULT): ElasticClientConfigurationInterface
    {
        return new ElasticClientConfiguration($this->configuration, $clientName);
    }
}
