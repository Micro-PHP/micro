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

namespace Micro\Plugin\EventEmitter\Tests\Unit\Business\Locator;

use Micro\Framework\EventEmitter\EventListenerInterface;
use Micro\Plugin\EventEmitter\Business\Locator\EventListenerClassLocator;
use Micro\Plugin\Locator\Facade\LocatorFacadeInterface;
use PHPUnit\Framework\TestCase;

class EventListenerClassLocatorTest extends TestCase
{
    public function testLookupListenerClasses(): void
    {
        $locatorFacade = $this->createMock(LocatorFacadeInterface::class);
        $locatorFacade->expects($this->once())->method('lookup')->with(EventListenerInterface::class)->willReturn(
            new \ArrayObject([
                'TestClass',
            ])
        );
        $provider = new EventListenerClassLocator($locatorFacade);
        $this->assertEquals(['TestClass'], $provider->lookupListenerClasses());
    }
}
