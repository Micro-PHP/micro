<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\LoggerMonolog\Configuration\Handler\Type;

use Micro\Plugin\LoggerMonolog\Business\Handler\Type\Stream\StreamHandler;
use Micro\Plugin\LoggerMonolog\Configuration\Handler\HandlerConfiguration;

class HandlerStreamConfiguration extends HandlerConfiguration implements HandlerStreamConfigurationInterface
{
    protected const CFG_LOG_FILE = 'LOGGER_%s_FILE';
    protected const CFG_USE_LOCKING = 'LOGGER_%s_USE_LOCKING';

    public function getLogFile(): string
    {
        return $this->get(
            self::CFG_LOG_FILE,
            $this->configuration->get('BASE_PATH').'/var/log/micro/app.log'
        );
    }

    public function useLocking(): bool
    {
        return $this->get(self::CFG_USE_LOCKING, false);
    }

    public static function type(): string
    {
        return self::TYPE;
    }

    public function getHandlerClassName(): string
    {
        return StreamHandler::class;
    }
}
