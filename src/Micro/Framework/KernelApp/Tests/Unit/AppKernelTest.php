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

namespace Micro\Framework\KernelApp\Tests\Unit;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\Kernel\Plugin\PluginBootLoaderInterface;
use Micro\Framework\KernelApp\AppKernel;
use PHPUnit\Framework\TestCase;

class AppKernelTest extends TestCase
{
    private AppKernel $kernel;

    protected function setUp(): void
    {
        $this->kernel = $this->getMockBuilder(AppKernel::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([[
            ], [\stdClass::class], 'dev'])
            ->onlyMethods([
                'createBootLoaderCollection',
                'createInitActionProcessor',
                'createTerminateActionProcessor',
            ])
            ->getMock()
        ;
    }

    public function testAppKernel()
    {
        $app = new AppKernel();

        $this->assertInstanceOf(KernelInterface::class, $app);

        $app->run();

        $this->assertInstanceOf(Container::class, $app->container());

        $app->terminate();
    }

    public function testAddBootLoader()
    {
        $bootLoader = $this->createMock(PluginBootLoaderInterface::class);
        $bootLoader
            ->method('boot');

        $app = new AppKernel([], []);
        $appReturn = $app->addBootLoader($bootLoader);

        $this->assertEquals($app, $appReturn);

        $app->run();
    }

    public function testLoadPlugin()
    {
        $pk = $this->createMock(KernelInterface::class);
        $pk->expects($this->once())
            ->method('loadPlugin')
            ->with('test_plugin');

        $app = $this->getMockBuilder(AppKernel::class)
            ->enableOriginalConstructor()
            ->onlyMethods(['kernel'])
            ->getMock()
        ;

        $app
            ->expects($this->once())
            ->method('kernel')
            ->willReturn($pk);

        $app->loadPlugin('test_plugin');
    }

    public function testKernelFail()
    {
        $app = new AppKernel();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Method Micro\Kernel\App\AppKernel::plugins can not be called before Micro\Framework\Kernel\KernelInterface::run() execution.');

        $this->assertNotNull($app->plugins());
    }

    public function testTerminate()
    {
        $this->kernel
            ->expects($this->once())
            ->method('createTerminateActionProcessor');

        $this->kernel
            ->expects($this->once())
            ->method('createInitActionProcessor');

        $this->kernel->terminate();
        $this->kernel->run();
        $this->kernel->run();
        $this->kernel->terminate();
    }

    /**
     * @dataProvider dataProviderIsDevMode
     */
    public function testIsDevMode(string $env, bool $isDev)
    {
        $app = new AppKernel(
            [],
            [],
            $env
        );

        $app->run();

        $this->assertEquals($isDev, $app->isDevMode());
        $this->assertEquals($app->environment(), $env);
    }

    public static function dataProviderIsDevMode(): array
    {
        return [
            ['dev', true],
            ['dev-', true],
            ['devel', true],
            ['develop', true],
            ['test', false],
            ['test-dev', false],
        ];
    }
}
