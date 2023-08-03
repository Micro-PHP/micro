<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpLogger\Tests\Unit;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Plugin\HttpLogger\HttpLoggerPluginConfiguration;
use Micro\Plugin\HttpLogger\HttpLoggerPluginConfigurationInterface;
use Micro\Plugin\Logger\LoggerPluginConfiguration;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class HttpLoggerPluginConfigurationTest extends TestCase
{
    /**
     * @var MockObject<ApplicationConfigurationInterface>
     */
    private ApplicationConfigurationInterface $applicationConfiguration;
    private HttpLoggerPluginConfigurationInterface $loggerConfiguration;

    protected function setUp(): void
    {
        $this->applicationConfiguration = $this->createMock(ApplicationConfigurationInterface::class);

        $this->loggerConfiguration = new HttpLoggerPluginConfiguration(
            $this->applicationConfiguration
        );
    }

    public function testGetWeight()
    {
        $this->assertIsInt($this->loggerConfiguration->getWeight());
    }

    public function testGetErrorLogFormat()
    {
        $this->applicationConfiguration
            ->expects($this->once())
            ->method('get')
            ->with(HttpLoggerPluginConfiguration::CFG_HTTP_LOGGER_ERROR_FORMAT)
            ->willReturn(HttpLoggerPluginConfiguration::LOGGER_ERROR_FORMAT_DEFAULT);

        $this->assertEquals(HttpLoggerPluginConfiguration::LOGGER_ERROR_FORMAT_DEFAULT, $this->loggerConfiguration->getErrorLogFormat());
    }

    public function testGetAccessLoggerName()
    {
        $this->applicationConfiguration
            ->expects($this->once())
            ->method('get')
            ->with(HttpLoggerPluginConfiguration::CFG_LOGGER_ACCESS)
            ->willReturn(LoggerPluginConfiguration::LOGGER_NAME_DEFAULT);

        $this->assertEquals(LoggerPluginConfiguration::LOGGER_NAME_DEFAULT, $this->loggerConfiguration->getAccessLoggerName());
    }

    public function testGetAccessLogFormat()
    {
        $this->applicationConfiguration
            ->expects($this->once())
            ->method('get')
            ->with(HttpLoggerPluginConfiguration::CFG_HTTP_LOGGER_ACCESS_FORMAT)
            ->willReturn(HttpLoggerPluginConfiguration::LOGGER_ACCESS_FORMAT_DEFAULT);

        $this->assertEquals(HttpLoggerPluginConfiguration::LOGGER_ACCESS_FORMAT_DEFAULT, $this->loggerConfiguration->getAccessLogFormat());
    }

    public function testGetRequestHeadersSecuredList()
    {
        $this->applicationConfiguration
            ->expects($this->once())
            ->method('get')
            ->with(HttpLoggerPluginConfiguration::CFG_LOGGER_HEADERS_SECURED)
            ->willReturn('Authorization');

        $this->assertEquals(
            ['Authorization'],
            $this->loggerConfiguration->getRequestHeadersSecuredList()
        );
    }

    public function testGetErrorLoggerName()
    {
        $this->applicationConfiguration
            ->expects($this->once())
            ->method('get')
            ->with(HttpLoggerPluginConfiguration::CFG_LOGGER_ERROR)
            ->willReturn(LoggerPluginConfiguration::LOGGER_NAME_DEFAULT);

        $this->assertEquals(LoggerPluginConfiguration::LOGGER_NAME_DEFAULT, $this->loggerConfiguration->getErrorLoggerName());
    }
}
