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

namespace Micro\Plugin\Elastic\Configuration;

use Micro\Plugin\Elastic\Configuration\Client\ElasticClientConfigurationInterface;

interface ElasticPluginConfigurationInterface
{
    public const CLIENT_DEFAULT = 'default';

    /**
     * @param string $clientName
     *
     * @return ElasticClientConfigurationInterface
     */
    public function getClientConfiguration(string $clientName = self::CLIENT_DEFAULT): ElasticClientConfigurationInterface;
}
