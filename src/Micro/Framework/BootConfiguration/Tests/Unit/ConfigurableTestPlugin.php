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

use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 *
 * @method ConfigurableTestPluginConfiguration configuration()
 */
class ConfigurableTestPlugin implements ConfigurableInterface
{
    use PluginConfigurationTrait;

    public function getEnv(): string
    {
        return $this->configuration()->getEnv();
    }

    /**
     * @return string[]
     */
    public function getList(): array
    {
        return $this->configuration()->getList();
    }

    public function getAlreadyList(): array
    {
        return $this->configuration()->getAlreadyList();
    }

    public function getListWithoutSeparator(): array
    {
        return $this->configuration()->getListWithoutSeparator();
    }

    public function getConfigRoutingKeyValue(): string
    {
        return $this->configuration()->getRoutingKeyConfig()->testTestValueString();
    }
}
