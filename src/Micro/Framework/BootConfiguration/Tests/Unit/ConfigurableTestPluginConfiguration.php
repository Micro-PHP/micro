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

namespace Micro\Framework\BootConfiguration\Tests\Unit;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class ConfigurableTestPluginConfiguration extends PluginConfiguration
{
    public function getEnv(): string
    {
        return $this->configuration->get('APP_ENV', null, false);
    }

    public function getList(): array
    {
        $list = $this->configuration->get('ENV_LIST', null, false);

        return $this->explodeStringToArray($list);
    }

    public function getAlreadyList(): array
    {
        return $this->explodeStringToArray($this->getList());
    }

    public function getListWithoutSeparator(): array
    {
        return $this->explodeStringToArray($this->configuration->get('ENV_LIST', null, false), '');
    }

    public function getRoutingKeyConfig(): ConfigurableTestPluginRoutingConfiguration
    {
        return new ConfigurableTestPluginRoutingConfiguration($this->configuration, 'TEST');
    }
}
