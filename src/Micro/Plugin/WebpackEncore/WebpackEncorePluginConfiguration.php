<?php

declare(strict_types=1);

/*
 * This file is part of the WebpackEncore plugin for Micro Framework.
 * (c) Oleksii Bulba <oleksii.bulba@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Micro\Plugin\WebpackEncore;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;

/**
 * @codeCoverageIgnore
 */
class WebpackEncorePluginConfiguration extends PluginConfiguration implements WebpackEncorePluginConfigurationInterface
{
    public const CFG_OUTPUT_PATH = 'WEBPACK_ENCORE_OUTPUT_PATH';

    public function getOutputPath(): string
    {
        return (string) $this->configuration->get(self::CFG_OUTPUT_PATH,
            ((string) $this->configuration->get('BASE_PATH')).'/public/build'
        );
    }
}
