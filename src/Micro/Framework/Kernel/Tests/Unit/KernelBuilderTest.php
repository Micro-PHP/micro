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
use Micro\Framework\Kernel\KernelBuilder;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\Kernel\Plugin\PluginBootLoaderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class KernelBuilderTest extends TestCase
{
    private KernelBuilder $builder;

    protected function setUp(): void
    {
        $this->builder = new KernelBuilder();
    }

    public function testBuildWithoutContainer()
    {
        $kernel = $this->builder
            ->setApplicationPlugins([])
            ->build();

        $this->assertInstanceOf(KernelInterface::class, $kernel);
    }

    public function testBuildWithContainer()
    {
        $container = new Container();

        $kernel = $this->builder
            ->setApplicationPlugins([])
            ->setContainer($container)
            ->build();

        $this->assertInstanceOf(KernelInterface::class, $kernel);
        $this->assertEquals($container, $kernel->container());
    }

    public function testBootLoaders()
    {
        $kernel = $this->builder
            ->setApplicationPlugins([
                \stdClass::class,
            ])
            ->addBootLoaders([
                $this->createBootLoader(),
                $this->createBootLoader(),
            ])
            ->addBootLoader($this->createBootLoader())
            ->build()
        ;

        $kernel->run();
    }

    protected function createBootLoader(): MockObject|PluginBootLoaderInterface
    {
        $bl = $this->createMock(PluginBootLoaderInterface::class);
        $bl
            ->expects($this->once())
            ->method('boot');

        return $bl;
    }
}
