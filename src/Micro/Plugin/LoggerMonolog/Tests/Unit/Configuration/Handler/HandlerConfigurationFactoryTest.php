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

use Micro\Plugin\LoggerMonolog\Configuration\Handler\HandlerConfigurationFactory;
use Micro\Plugin\LoggerMonolog\Configuration\Handler\HandlerConfigurationInterface;
use Micro\Plugin\LoggerMonolog\Configuration\Handler\Type\HandlerStreamConfiguration;
use Micro\Plugin\LoggerMonolog\Configuration\Logger\MonologPluginConfigurationInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author ChatGPT Jan 9 Version.
 */
class HandlerConfigurationFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $config = $this->createMock(MonologPluginConfigurationInterface::class);
        $config->method('getHandlerType')->willReturn('stream');
        $class = new TestHandlerConfiguration();
        $classCollection = [\get_class($class)];
        $factory = new HandlerConfigurationFactory($config, $classCollection);
        $result = $factory->create('test');
        $this->assertInstanceOf(HandlerConfigurationInterface::class, $result);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCreateWithException(array $handlerClasses): void
    {
        $this->expectException(\RuntimeException::class);
        $config = $this->createMock(MonologPluginConfigurationInterface::class);
        $config->method('getHandlerType')
            ->willReturn('not_registered_handler_type');

        $factory = new HandlerConfigurationFactory($config, $handlerClasses);
        $factory->create('test');
    }

    public function dataProvider()
    {
        return [
            [
                [HandlerStreamConfiguration::class],
            ],
            [
                [],
            ],
            [
                [\stdClass::class],
            ],
        ];
    }
}
