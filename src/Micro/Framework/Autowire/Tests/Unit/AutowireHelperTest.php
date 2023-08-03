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

use Micro\Framework\Autowire\AutowireHelper;
use Micro\Framework\Autowire\ContainerAutowire;
use Micro\Framework\Autowire\Exception\AutowireException;
use Micro\Framework\DependencyInjection\Container;
use PHPUnit\Framework\TestCase;

class AutowireHelperTest extends TestCase
{
    private ContainerAutowire $container;

    private AutowireHelper $autowireHelper;

    protected function setUp(): void
    {
        $this->container = new ContainerAutowire(
            new Container()
        );

        $this->container->register(AutowireService::class,
            fn (AutowireServiceArgument $serviceArgument) => new AutowireService($serviceArgument));

        $this->container->register(AutowireServiceArgument::class,
            fn (Container $container): AutowireServiceArgument => new AutowireServiceArgument());

        $this->autowireHelper = new AutowireHelper($this->container);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testAutowire(mixed $autowireArgs, string|null $instanceOf = null, string|bool|null $throws = false)
    {
        if ($throws) {
            $this->expectException(true === $throws ? AutowireException::class : $throws);
        }

        $callback = $this->autowireHelper->autowire($autowireArgs);
        $autowired = $callback();

        if ($instanceOf) {
            $this->assertInstanceOf($instanceOf, $autowired);
        }

        if (!$instanceOf) {
            $this->assertEquals('HELLO!', $autowired);
        }

        if (AutowireServiceArgument::class === $instanceOf) {
            $this->assertEquals(AutowireServiceArgument::class, $autowired->getName());
        }

        if (AutowireService::class === $instanceOf) {
            $this->assertEquals(AutowireServiceArgument::class, $autowired->getService()->getName());
        }
    }

    public function dataProvider()
    {
        return [
            [
                AutowireService::class,
                AutowireService::class,
                false,
            ],
            [
                [new AutowireService(new AutowireServiceArgument()), 'setService'],
                AutowireService::class,
                false,
            ],
            [
                function (AutowireService $service): string {
                    $this->assertEquals(AutowireServiceArgument::class, $service->getService()->getName());

                    return 'HELLO!';
                },
                null,
                false,
            ],
            [
                [
                    new class() extends AutowireServiceArgument {
                        public function __invoke()
                        {
                            return 'HELLO!';
                        }
                    },
                ],
                null,
                false,
            ],
            // Should be throw Exception
            [   // Untyped parameter
                fn (AutowireService|AutowireServiceArgument $service) => \get_class($service),
                null,
                true,
            ],
            [   // Untyped parameter
                fn ($service) => \get_class($service),
                null,
                true,
            ],
            [
                [new AutowireService(new AutowireServiceArgument())],
                null,
                true,
            ],
            [
                [
                    AutowireService::class,
                    new AutowireServiceArgument(),
                ],
                null,
                true,
            ],
            [
                [
                    new AutowireServiceArgument(),
                    new AutowireServiceArgument(),
                ],
                null,
                true,
            ],
            [
                [
                    fn (AutowireService $service) => __CLASS__,
                ],
                null,
                true,
            ],
            [
                [12345],
                null,
                true,
            ],
            [
                'ClassNoExists',
                null,
                true,
            ],
            [
                ['ClassNoExists'],
                null,
                true,
            ],
            [
                [],
                null,
                true,
            ],
            [
                [null, null],
                null,
                true,
            ],
            [
                '',
                null,
                true,
            ],
            [
                [
                    null,
                    AutowireService::class,
                    AutowireService::class,
                ],
                null,
                true,
            ],
        ];
    }
}
