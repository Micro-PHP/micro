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

namespace Micro\Plugin\HttpExceptionsDev\Tests\Unit;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\HttpExceptionsDev\Configuration\HttpExceptionResponseDevPluginConfigurationInterface;
use Micro\Plugin\HttpExceptionsDev\HttpExceptionResponseDevPluginConfiguration;
use PHPUnit\Framework\TestCase;

class HttpExceptionResponseDevPluginConfigurationTest extends TestCase
{
    private HttpExceptionResponseDevPluginConfigurationInterface $configuration;

    protected function setUp(): void
    {
        $appConf = new DefaultApplicationConfiguration([
            'BASE_PATH' => '/test',
            'APP_ENV' => 'prod',
        ]);
        $this->configuration = new HttpExceptionResponseDevPluginConfiguration($appConf);
    }

    public function testGetProjectDir(): void
    {
        $this->assertEquals('/test/', $this->configuration->getProjectDir());
    }

    public function testIsDevMode(): void
    {
        $this->assertFalse($this->configuration->isDevMode());
    }

    public function testGetPriorityDecoration(): void
    {
        $this->assertEquals(HttpExceptionResponseDevPluginConfiguration::DECORATED_DEFAULT, $this->configuration->getPriorityDecoration());
    }
}
