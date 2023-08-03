<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\BootConfiguration\Configuration;

class PluginRoutingKeyConfiguration extends PluginConfiguration
{
    public function __construct(
        ApplicationConfigurationInterface $configuration,
        protected readonly string $configRoutingKey
    ) {
        parent::__construct($configuration);
    }

    protected function cfg(string $key): string
    {
        return sprintf($key, mb_strtoupper($this->configRoutingKey));
    }

    protected function get(string $key, mixed $default = null, bool $nullable = true): mixed
    {
        return $this->configuration->get(
            $this->cfg($key),
            $default,
            $nullable
        );
    }
}
