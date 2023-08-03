<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\LoggerMonolog\Configuration\Logger;

use Micro\Framework\BootConfiguration\Configuration\PluginRoutingKeyConfiguration;

class LoggerConfiguration extends PluginRoutingKeyConfiguration implements LoggerConfigurationInterface
{
    public const CFG_HANDLER_LIST = 'LOGGER_%s_HANDLERS';

    /**
     * {@inheritDoc}
     */
    public function getHandlerList(): iterable
    {
        $handlerListSource = $this->get(self::CFG_HANDLER_LIST, MonologPluginConfigurationInterface::HANDLER_DEFAULT);

        return $this->explodeStringToArray($handlerListSource);
    }

    public function getName(): string
    {
        return $this->configRoutingKey;
    }
}
