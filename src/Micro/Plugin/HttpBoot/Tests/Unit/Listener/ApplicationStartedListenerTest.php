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

namespace Micro\Plugin\HttpBoot\Tests\Unit\Listener;

use Micro\Framework\KernelApp\Business\Event\ApplicationReadyEventInterface;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use Micro\Plugin\HttpBoot\Listener\ApplicationStartedListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ApplicationStartedListenerTest extends TestCase
{
    private ApplicationStartedListener $applicationStartedListener;

    private HttpFacadeInterface $httpFacade;

    protected function setUp(): void
    {
        $this->httpFacade = $this->createMock(HttpFacadeInterface::class);
        $this->applicationStartedListener = new ApplicationStartedListener($this->httpFacade);
    }

    protected function createEvent(bool $isHttp)
    {
        $evt = $this->createMock(ApplicationReadyEventInterface::class);
        $evt->method('systemEnvironment')->willReturn($isHttp ? 'http' : 'cli');

        return $evt;
    }

    /**
     * @dataProvider dataProvider
     */
    public function testOn(bool $isHttp): void
    {
        $event = $this->createEvent($isHttp);

        if (!$isHttp) {
            $this->httpFacade
                ->expects($this->never())
                ->method('execute');
        } else {
            $this->httpFacade
                ->expects($this->once())
                ->method('execute')
                ->willReturn(
                    $this->createMock(Response::class)
                );
        }

        $this->applicationStartedListener->on($event);
    }

    public function dataProvider(): array
    {
        return [
            [true],
            [false],
        ];
    }

    public function testSupports()
    {
        $httpFacade = $this->createMock(HttpFacadeInterface::class);
        $listener = new ApplicationStartedListener($httpFacade);

        $this->assertTrue($listener->supports($this->createEvent(true)));
    }
}
