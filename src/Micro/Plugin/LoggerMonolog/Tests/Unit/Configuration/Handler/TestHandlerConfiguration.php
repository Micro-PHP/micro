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

namespace Micro\Plugin\LoggerMonolog\Tests\Unit\Configuration\Handler;

use Micro\Plugin\LoggerMonolog\Configuration\Handler\HandlerConfigurationInterface;
use Micro\Plugin\LoggerMonolog\Tests\Unit\Business\Handler\TestHandlerImpl;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class TestHandlerConfiguration implements HandlerConfigurationInterface
{
    public static function type(): string
    {
        return 'stream';
    }

    public function getHandlerClassName(): string
    {
        return TestHandlerImpl::class;
    }

    public function getLevelAsString(): string
    {
        // TODO: Implement getLevelAsString() method.
    }
}
