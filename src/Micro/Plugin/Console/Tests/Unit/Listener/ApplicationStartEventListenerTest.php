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

namespace Micro\Plugin\Console\Tests\Unit\Listener;

use Micro\Framework\EventEmitter\EventInterface;
use Micro\Framework\KernelApp\Business\Event\ApplicationReadyEventInterface;
use Micro\Plugin\Console\Facade\ConsoleApplicationFacadeInterface;
use Micro\Plugin\Console\Listener\ApplicationStartEventListener;
use PHPUnit\Framework\TestCase;

class ApplicationStartEventListenerTest extends TestCase
{
    private ApplicationStartEventListener $listener;

    private ConsoleApplicationFacadeInterface $facade;

    private ApplicationReadyEventInterface $event;

    protected function setUp(): void
    {
        $this->event = $this->createMock(ApplicationReadyEventInterface::class);
        $this->facade = $this->createMock(ConsoleApplicationFacadeInterface::class);
        $this->listener = new ApplicationStartEventListener(
            $this->facade,
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testOn(bool $isCli)
    {
        $this->event
            ->expects($this->once())
            ->method('systemEnvironment')
            ->willReturn($isCli ? 'cli' : 'http');

        $exceptedCall = $isCli ? $this->once() : $this->never();

        $this->facade->expects($exceptedCall)->method('run');

        $this->listener->on($this->event);
    }

    public function testSupports()
    {
        $this->assertFalse(ApplicationStartEventListener::supports(new class() implements EventInterface {}));
    }

    public static function dataProvider(): array
    {
        return [
            [true],
            [false],
        ];
    }
}
