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

namespace Micro\Framework\Kernel\Tests\Unit;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\Kernel\Kernel;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\Kernel\Plugin\PluginBootLoaderInterface;
use PHPUnit\Framework\TestCase;

class KernelTest extends TestCase
{
    private KernelInterface $kernel;

    private Container $container;

    protected function setUp(): void
    {
        $plugins = [];
        for ($i = 0; $i < 3; ++$i) {
            $plugins[] = \stdClass::class;
        }

        $bootLoaders = [];
        for ($i = 0; $i < 3; ++$i) {
            $bootLoader = $this->createMock(PluginBootLoaderInterface::class);
            $bootLoader
                ->expects($this->any())
                ->method('boot');

            $bootLoaders[] = $bootLoader;
        }

        $this->container = new Container();

        $this->kernel = new Kernel(
            $plugins,
            [],
            $this->container,
        );

        $this->kernel->setBootLoaders($bootLoaders);
        $this->kernel->addBootLoader($this->createMock(PluginBootLoaderInterface::class));

        $this->kernel->run();
    }

    public function testExceptionWhenTryBootloaderInstallAfterKernelRun()
    {
        $this->expectException(\LogicException::class);
        $this->kernel->addBootLoader($this->createMock(PluginBootLoaderInterface::class));
    }

    public function testKernelPlugins()
    {
        foreach ($this->kernel->plugins(\stdClass::class) as $plugin) {
            $this->assertInstanceOf(\stdClass::class, $plugin);
        }

        foreach ($this->kernel->plugins() as $plugin) {
            $this->assertInstanceOf(\stdClass::class, $plugin);
        }
    }

    public function testRunAgain()
    {
        $kernel = $this->getMockBuilder(Kernel::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs(
                [
                    [],
                    [],
                    new Container(),
                ]
            )
            ->onlyMethods([
                'loadPlugins',
            ])
        ->getMock();

        $kernel
            ->expects($this->once())
            ->method('loadPlugins');

        $kernel->run();
        $kernel->run();
    }

    public function testContainer()
    {
        $this->assertEquals($this->container, $this->kernel->container());
    }
}
