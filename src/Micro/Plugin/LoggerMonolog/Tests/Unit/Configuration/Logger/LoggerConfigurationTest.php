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

namespace Micro\Plugin\LoggerMonolog\Tests\Unit\Configuration\Logger;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\LoggerMonolog\Configuration\Logger\LoggerConfiguration;
use PHPUnit\Framework\TestCase;

/**
 * @author ChatGPT Jan 9 Version.
 */
class LoggerConfigurationTest extends TestCase
{
    public function testGetHandlerList()
    {
        $appConfig = new DefaultApplicationConfiguration([
            'LOGGER_DEFAULT_HANDLERS' => 'handler1,handler2,handler3',
        ]);

        $loggerConfig = new LoggerConfiguration($appConfig, 'default');
        $this->assertEquals(['handler1', 'handler2', 'handler3'], $loggerConfig->getHandlerList());
    }

    public function testGetName()
    {
        $loggerConfig = new LoggerConfiguration($this->createMock(ApplicationConfigurationInterface::class), 'test_name');
        $this->assertEquals('test_name', $loggerConfig->getName());
    }
}
