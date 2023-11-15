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

namespace Micro\Plugin\HttpRoadrunner\Facade;

use Micro\Plugin\HttpRoadrunner\HttpRoadrunnerPluginConfigurationInterface;

final readonly class HttpRoadrunnerFacade implements HttpRoadrunnerFacadeInterface
{
    public function __construct(
        private HttpRoadrunnerPluginConfigurationInterface $httpRoadrunnerPluginConfiguration
    ) {
    }

    public function getGcCollectCyclesCount(): int
    {
        return $this->httpRoadrunnerPluginConfiguration->getGcCollectCyclesCount();
    }
}
