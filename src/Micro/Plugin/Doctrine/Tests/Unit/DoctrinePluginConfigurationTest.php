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

namespace Micro\Plugin\Doctrine\Tests\Unit;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Plugin\Doctrine\Configuration\EntityManagerConfigurationInterface;
use Micro\Plugin\Doctrine\DoctrinePluginConfiguration;
use Micro\Plugin\Doctrine\DoctrinePluginConfigurationInterface;
use PHPUnit\Framework\TestCase;

class DoctrinePluginConfigurationTest extends TestCase
{
    private DoctrinePluginConfigurationInterface $pluginConfiguration;

    private ApplicationConfigurationInterface $applicationConfiguration;

    protected function setUp(): void
    {
        $this->applicationConfiguration = $this->createMock(ApplicationConfigurationInterface::class);

        $this->pluginConfiguration = new DoctrinePluginConfiguration($this->applicationConfiguration);
    }

    public function testGetManagerConfiguration(): void
    {
        $this->applicationConfiguration
            ->expects($this->once())
            ->method('get')
            ->with('ORM_TEST_DRIVER')
            ->willReturn('pdo_mysql')
        ;

        $emCfg = $this->pluginConfiguration->getManagerConfiguration('test');
        $this->assertInstanceOf(EntityManagerConfigurationInterface::class, $emCfg);
        $this->assertEquals('pdo_mysql', $emCfg->getDriverName());
    }

    /**
     * @dataProvider dataProviderIsDevMode
     */
    public function testIsDevMode(bool $isDev): void
    {
        $this->applicationConfiguration
            ->expects($this->once())
            ->method('get')
            ->with('APP_ENV')
            ->willReturn($isDev ? 'dev-test' : 'prod');

        $this->assertEquals($isDev, $this->pluginConfiguration->isDevMode());
    }

    public static function dataProviderIsDevMode(): array
    {
        return [
            [true],
            [false],
        ];
    }

    public function testGetConnectionList(): void
    {
        $listString = 'default, test';
        $list = ['default', 'test']; // Because with space after comma.
        $this->applicationConfiguration
            ->expects($this->once())
            ->method('get')
            ->with('ORM_CONNECTION_LIST')
            ->willReturn($listString);

        $this->assertEquals($list, $this->pluginConfiguration->getConnectionList());
    }
}
