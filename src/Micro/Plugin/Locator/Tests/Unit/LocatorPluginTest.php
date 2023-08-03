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

namespace Micro\Plugin\Locator\Tests\Unit;

use Micro\Framework\KernelApp\AppKernel;
use Micro\Plugin\EventEmitter\Business\Locator\EventListenerClassLocatorInterface;
use Micro\Plugin\Locator\Facade\LocatorFacadeInterface;
use PHPUnit\Framework\TestCase;

class LocatorPluginTest extends TestCase
{
    public function testPlugin()
    {
        $kernel = new AppKernel(
            [],
            [
                \stdClass::class,
            ],
            'dev'
        );

        $kernel->run();
        /** @var LocatorFacadeInterface $locator */
        $locator = $kernel->container()->get(LocatorFacadeInterface::class);
        $i = 0;
        foreach ($locator->lookup(EventListenerClassLocatorInterface::class) as $internalClass) {
            ++$i;
            $this->assertTrue(\in_array(EventListenerClassLocatorInterface::class, class_implements($internalClass)));
        }

        foreach ($locator->lookup('ClassNoExists') as $plugin) {
            throw new \Exception('Oh, no.');
        }

        $this->assertTrue((bool) $i);
    }
}
