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

namespace Micro\Plugin\Logger\Tests\Unit;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Plugin\Logger\Configuration\LoggerPluginConfigurationInterface;
use Micro\Plugin\Logger\Configuration\LoggerProviderTypeConfigurationInterface;
use Micro\Plugin\Logger\LoggerPluginConfiguration;
use PHPUnit\Framework\TestCase;

class LoggerPluginConfigurationTest extends TestCase
{
    private LoggerPluginConfigurationInterface $loggerPluginConfiguration;

    private ApplicationConfigurationInterface $applicationConfiguration;

    protected function setUp(): void
    {
        $this->applicationConfiguration = $this->createMock(ApplicationConfigurationInterface::class);

        $this->loggerPluginConfiguration = new LoggerPluginConfiguration(
            $this->applicationConfiguration
        );
    }

    public function testGetLoggerDefaultName()
    {
        $this->assertEquals(
            'default',
            $this->loggerPluginConfiguration->getLoggerDefaultName()
        );
    }

    public function testGetLoggerProviderTypeConfig()
    {
        $configProviderTypeConfig = $this->loggerPluginConfiguration->getLoggerProviderTypeConfig('default');

        $this->assertInstanceOf(LoggerProviderTypeConfigurationInterface::class, $configProviderTypeConfig);
    }
}
