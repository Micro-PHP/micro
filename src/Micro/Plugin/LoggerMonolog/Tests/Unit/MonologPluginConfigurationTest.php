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

namespace Micro\Plugin\LoggerMonolog\Tests\Unit;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\LoggerMonolog\Configuration\Logger\LoggerConfigurationInterface;
use Micro\Plugin\LoggerMonolog\Configuration\Logger\MonologPluginConfigurationInterface;
use Micro\Plugin\LoggerMonolog\MonologPluginConfiguration;
use PHPUnit\Framework\TestCase;

class MonologPluginConfigurationTest extends TestCase
{
    private ApplicationConfigurationInterface $applicationConfiguration;

    private MonologPluginConfigurationInterface $testObject;

    protected function setUp(): void
    {
        $this->applicationConfiguration = new DefaultApplicationConfiguration(
            [
                'LOGGER_TEST_TYPE' => 'TestType',
                'LOGGER_LIST' => 'logger1,logger2,logger3',
                'LOGGER_HANDLER_LIST' => 'handler1,handler2,handler3',
            ]
        );

        $this->testObject = new MonologPluginConfiguration(
            $this->applicationConfiguration
        );
    }

    public function testGetHandlerType()
    {
        $this->assertEquals('TestType', $this->testObject->getHandlerType('test'));
    }

    public function testGetLoggerlist()
    {
        $this->assertEquals(['logger1', 'logger2', 'logger3'], $this->testObject->getLoggerList());
    }

    public function testGetLoggerConfiguration()
    {
        $this->assertInstanceOf(LoggerConfigurationInterface::class, $this->testObject->getLoggerConfiguration('test'));
    }

    public function testGetHandlerList()
    {
        $this->assertEquals(['handler1', 'handler2', 'handler3'], $this->testObject->getHandlerList());
    }

    public function testGetHandlerDefault()
    {
        $this->assertEquals('default', $this->testObject->getHandlerDefault());
    }

    public function testApplicationConfiguration()
    {
        $this->assertInstanceOf(ApplicationConfigurationInterface::class, $this->testObject->applicationConfiguration());
    }
}
