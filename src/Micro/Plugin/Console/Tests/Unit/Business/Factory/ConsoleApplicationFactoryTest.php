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

namespace Micro\Plugin\Console\Tests\Unit\Business\Factory;

use Micro\Framework\Autowire\AutowireHelperInterface;
use Micro\Plugin\Console\Business\Factory\ConsoleApplicationFactory;
use Micro\Plugin\Locator\Facade\LocatorFacadeInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class ConsoleApplicationFactoryTest extends TestCase
{
    public function testCreate()
    {
        $commands = new \ArrayObject([ConsoleApplicationCommandTest::class]);
        $locator = $this->createMock(LocatorFacadeInterface::class);
        $locator
            ->expects($this->once())
            ->method('lookup')
            ->willReturn($commands);

        $autowire = $this->createMock(AutowireHelperInterface::class);
        $autowire
            ->expects($this->once())
            ->method('autowire')
            ->with(ConsoleApplicationCommandTest::class)
            ->willReturn(fn () => new ConsoleApplicationCommandTest());

        $factory = new ConsoleApplicationFactory(
            $locator,
            $autowire,
        );

        $app = $factory->create();
        $this->assertInstanceOf(Application::class, $app);
        $this->assertInstanceOf(ConsoleApplicationCommandTest::class, $app->get('cmd:test'));
    }
}

class ConsoleApplicationCommandTest extends Command
{
    public function __construct()
    {
        parent::__construct('cmd:test');
    }
}
