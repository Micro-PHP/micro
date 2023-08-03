<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Plugin\HttpCore\HttpCorePluginConfiguration;
use PHPUnit\Framework\TestCase;

class HttpCorePluginConfigurationTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testGetRouteLocatorType(string $configValue)
    {
        $applicationConfiguration = $this->createMock(ApplicationConfigurationInterface::class);
        $applicationConfiguration
            ->expects($this->once())
            ->method('get')
            ->with('MICRO_HTTP_ROUTE_LOCATOR')
            ->willReturn($configValue);

        $pluginConfiguration = new HttpCorePluginConfiguration(
            $applicationConfiguration,
        );

        $this->assertEquals($configValue, $pluginConfiguration->getRouteLocatorType());
    }

    public static function dataProvider(): array
    {
        return [
            ['code'], ['test'],
        ];
    }
}
