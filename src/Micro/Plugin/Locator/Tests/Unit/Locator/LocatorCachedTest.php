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

namespace Micro\Plugin\Locator\Tests\Unit\Locator;

use Micro\Plugin\Locator\Locator\Locator;
use Micro\Plugin\Locator\Locator\LocatorCached;
use Micro\Plugin\Locator\Locator\LocatorInterface;
use PHPUnit\Framework\TestCase;

class LocatorCachedTest extends TestCase
{
    public function testLookup()
    {
        $acceptedRes = [
            \stdClass::class,
            Locator::class,
        ];

        $decorated = $this->createMock(LocatorInterface::class);
        $decorated->expects($this->once())->method('lookup')->with(
            \stdClass::class
        )->willReturn(new \ArrayObject($acceptedRes));

        $locatorCached = new LocatorCached($decorated);
        $it1 = $locatorCached->lookup(\stdClass::class);
        $results1 = [];
        foreach ($it1 as $class) {
            $results1[] = $class;
        }

        $this->assertEquals($acceptedRes, $results1);

        $results2 = [];
        $it2 = $locatorCached->lookup(\stdClass::class);
        foreach ($it2 as $class) {
            $results2[] = $class;
        }

        $this->assertEquals($acceptedRes, $results2);
    }
}
