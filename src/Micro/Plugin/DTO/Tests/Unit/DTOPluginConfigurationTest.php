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

namespace Micro\Plugin\DTO\Tests\Unit;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\DTO\DTOPluginConfiguration;
use PHPUnit\Framework\TestCase;

class DTOPluginConfigurationTest extends TestCase
{
    public function testDefaults(): void
    {
        $appCfg = new DefaultApplicationConfiguration([]);
        $pluginCfg = new DTOPluginConfiguration($appCfg);

        $this->assertEquals([], $pluginCfg->getSchemaPaths());
        $this->assertNull($pluginCfg->getLoggerName());
        $this->assertEquals('Transfer', $pluginCfg->getClassSuffix());
        $this->assertEquals('src/Generated', $pluginCfg->getOutputPath());
        $this->assertEquals('App\DTO\Generated', $pluginCfg->getNamespaceGeneral());
        $this->assertEquals('*.transfer.xml', $pluginCfg->getSourceFileMask());
    }

    public function testOverride(): void
    {
        $appCfg = new DefaultApplicationConfiguration([
            'DTO_CLASS_NAMESPACE_GENERAL' => 'test-namespace',
            'DTO_CLASS_SUFFIX' => 'Test',
            'DTO_CLASS_SOURCE_PATH' => __DIR__,
            'DTO_CLASS_SOURCE_FILE_MASK' => '*.dto.xml',
            'DTO_GENERATED_PATH_OUTPUT' => '/app',
            'DTO_LOGGER_NAME' => 'default',
        ]);

        $pluginCfg = new DTOPluginConfiguration($appCfg);

        $this->assertEquals([__DIR__], $pluginCfg->getSchemaPaths());
        $this->assertEquals('default', $pluginCfg->getLoggerName());
        $this->assertEquals('Test', $pluginCfg->getClassSuffix());
        $this->assertEquals('/app', $pluginCfg->getOutputPath());
        $this->assertEquals('test-namespace', $pluginCfg->getNamespaceGeneral());
        $this->assertEquals('*.dto.xml', $pluginCfg->getSourceFileMask());
    }
}
