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

namespace Micro\Plugin\LoggerMonolog\Tests\Unit\Configuration\Handler\Type;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\LoggerMonolog\Business\Handler\Type\Stream\StreamHandler;
use Micro\Plugin\LoggerMonolog\Configuration\Handler\Type\HandlerStreamConfiguration;
use PHPUnit\Framework\TestCase;

class HandlerStreamConfigurationTest extends TestCase
{
    private ApplicationConfigurationInterface $applicationConfiguration;

    protected function setUp(): void
    {
        $this->applicationConfiguration = new DefaultApplicationConfiguration(
            [
                'LOGGER_TEST_FILE' => '/var/log/test.log',
                'LOGGER_TEST_USE_LOCKING' => true,
            ]
        );
    }

    public function testParameters()
    {
        $handlerConfig = new HandlerStreamConfiguration($this->applicationConfiguration, 'test');

        $this->assertEquals('/var/log/test.log', $handlerConfig->getLogFile());
        $this->assertTrue($handlerConfig->useLocking());
    }

    public function testDefaultParameters()
    {
        $handlerConfig = new HandlerStreamConfiguration(new DefaultApplicationConfiguration([
            'BASE_PATH' => '/home/test/app',
        ]), 'test');

        $this->assertEquals(StreamHandler::class, $handlerConfig->getHandlerClassName());
        $this->assertEquals('/home/test/app/var/log/micro/app.log', $handlerConfig->getLogFile());
        $this->assertFalse($handlerConfig->useLocking());
    }
}
