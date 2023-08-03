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

namespace Micro\Framework\BootConfiguration\Tests\Unit\Boot;

use Micro\Framework\BootConfiguration\Boot\ConfigurationProviderBootLoader;
use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfigurationFactory;
use Micro\Framework\BootConfiguration\Tests\Unit\ConfigurableTestPlugin;
use PHPUnit\Framework\TestCase;

class ConfigurationProviderBootLoaderTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testBoot(mixed $configuration)
    {
        $plugin = new ConfigurableTestPlugin();
        $bootLoader = new ConfigurationProviderBootLoader($configuration);
        $bootLoader->boot($plugin);

        $this->assertEquals('test', $plugin->getEnv());
        $this->assertEquals(['a', 'b', 'c', 'd'], $plugin->getList());
        $this->assertEquals(['a', 'b', 'c', 'd'], $plugin->getAlreadyList());
        $this->assertEquals(['a,b,c,d'], $plugin->getListWithoutSeparator());
        $this->assertEquals('OK', $plugin->getConfigRoutingKeyValue());
    }

    public static function dataProvider(): array
    {
        $cfgArr = [
            'APP_ENV' => 'test',
            'ENV_LIST' => 'a,b,c,d',
            'CONFIG_TEST_VALUE' => 'OK',
        ];

        return [
            [$cfgArr],
            [new DefaultApplicationConfiguration($cfgArr)],
            [new DefaultApplicationConfigurationFactory($cfgArr)],
        ];
    }
}
