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

readonly class DefaultApplicationConfigurationFactory implements ApplicationConfigurationFactoryInterface
{
    /**
     * @param array<string, mixed> $configuration
     */
    public function __construct(
        private array $configuration
    ) {
    }

    public function create(): ApplicationConfigurationInterface
    {
        return new DefaultApplicationConfiguration($this->configuration);
    }
}
