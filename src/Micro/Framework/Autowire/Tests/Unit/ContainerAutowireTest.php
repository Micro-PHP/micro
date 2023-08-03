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

namespace Micro\Framework\Autowire\Tests\Unit;

use Micro\Framework\Autowire\ContainerAutowire;
use Micro\Framework\DependencyInjection\Container;
use PHPUnit\Framework\TestCase;

class ContainerAutowireTest extends TestCase
{
    private ContainerAutowire $container;

    protected function setUp(): void
    {
        $this->container = new ContainerAutowire(
            new Container()
        );

        $this->container->register(AutowireService::class,
            fn (AutowireServiceArgument $serviceArgument) => new AutowireService($serviceArgument));

        $this->container->register(AutowireServiceArgument::class,
            fn (Container $container): AutowireServiceArgument => new AutowireServiceArgument());
    }

    public function testAutowire()
    {
        $this->assertEquals(
            AutowireServiceArgument::class,
            $this->container->get(AutowireService::class)->getService()->getName(),
        );
    }

    public function testDecorated()
    {
        $this->assertTrue($this->container->has(AutowireServiceArgument::class));
        $this->container->decorate(AutowireService::class, fn (AutowireService $dec) => new NewDecoratorForDefault($dec));

        $this->assertInstanceOf(NewDecoratorForDefault::class, $this->container->get(AutowireService::class));
    }
}

class NewDecoratorForDefault extends AutowireService
{
    public function __construct(AutowireService $decorated)
    {
        parent::__construct($decorated->getService());
    }
}
