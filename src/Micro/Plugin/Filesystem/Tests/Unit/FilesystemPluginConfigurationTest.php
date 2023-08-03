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

namespace Micro\Plugin\Filesystem\Tests\Unit;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Framework\BootConfiguration\Configuration\Exception\InvalidConfigurationException;
use Micro\Framework\BootConfiguration\Configuration\PluginRoutingKeyConfiguration;
use Micro\Plugin\Filesystem\Configuration\Adapter\FilesystemAdapterConfigurationInterface;
use Micro\Plugin\Filesystem\Configuration\FilesystemPluginConfigurationInterface;
use Micro\Plugin\Filesystem\FilesystemPluginConfiguration;
use PHPUnit\Framework\TestCase;

class FilesystemPluginConfigurationTest extends TestCase
{
    private ApplicationConfigurationInterface $applicationConfiguration;
    private FilesystemPluginConfigurationInterface $pluginConfiguration;

    protected function setUp(): void
    {
        $this->applicationConfiguration = $this->createMock(ApplicationConfigurationInterface::class);
        $this->pluginConfiguration = new FilesystemPluginConfiguration($this->applicationConfiguration);
    }

    public function testGetAdapterType()
    {
        $this->applicationConfiguration
            ->expects($this->once())
            ->method('get')
            ->with('MICRO_FS_TEST_TYPE')
            ->willReturn('example');

        $this->assertEquals('example', $this->pluginConfiguration->getAdapterType('test'));
    }

    public function testGetNoExistsAdapterConfiguration()
    {
        $this->expectException(InvalidConfigurationException::class);
        $this->pluginConfiguration->getAdapterConfiguration('no-exists');
    }

    public function testGetAdapterConfiguration()
    {
        $adapterCfg = $this->pluginConfiguration->createAdapterConfiguration(
            'test',
            ExampleFilesystemAdapterConfiguration::class
        );

        $this->assertEquals('hello', $adapterCfg->getPublicUrl());
    }

    public function testAdapterInvalidConfiguration()
    {
        $this->expectException(\TypeError::class);
        $this->pluginConfiguration->createAdapterConfiguration(
            'test',
            \stdClass::class
        );
    }

    public function testCreateAdapterConfiguration()
    {
        $this->expectException(InvalidConfigurationException::class);
        $this->pluginConfiguration->createAdapterConfiguration('test', 'ClassNoExists');
    }
}

class ExampleFilesystemAdapterConfiguration extends PluginRoutingKeyConfiguration implements FilesystemAdapterConfigurationInterface
{
    public function getPublicUrl(): null|string
    {
        return 'hello';
    }
}
