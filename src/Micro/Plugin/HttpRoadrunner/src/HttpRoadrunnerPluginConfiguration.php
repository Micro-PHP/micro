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

namespace Micro\Plugin\HttpRoadrunner;


use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;

final class HttpRoadrunnerPluginConfiguration extends PluginConfiguration implements HttpRoadrunnerPluginConfigurationInterface
{
    public const CFG_GC_COLLECT_CYCLES_COUNT = 'MICRO_RR_GC_COLLECT_CYCLES_COUNT';

    public const CFG_GC_COLLECT_CYCLES_COUNT_DEFAULT = 10;

    public function getGcCollectCyclesCount(): int
    {
        return (int) $this->configuration
            ->get(
                self::CFG_GC_COLLECT_CYCLES_COUNT,
                self::CFG_GC_COLLECT_CYCLES_COUNT_DEFAULT,
                false
            );
    }
}
