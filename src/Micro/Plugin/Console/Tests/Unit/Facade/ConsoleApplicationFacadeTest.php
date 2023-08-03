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

namespace Micro\Plugin\Console\Tests\Unit\Facade;

use Micro\Plugin\Console\Business\Factory\ConsoleApplicationFactoryInterface;
use Micro\Plugin\Console\Facade\ConsoleApplicationFacade;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;

class ConsoleApplicationFacadeTest extends TestCase
{
    public function testRun()
    {
        $app = $this->createMock(Application::class);
        $app->expects($this->once())->method('run')->willReturn(1);
        $factory = $this->createMock(ConsoleApplicationFactoryInterface::class);
        $factory->expects($this->once())->method('create')->willReturn($app);
        $facade = new ConsoleApplicationFacade(
            $factory,
        );

        $this->assertEquals(1, $facade->run());
    }
}
