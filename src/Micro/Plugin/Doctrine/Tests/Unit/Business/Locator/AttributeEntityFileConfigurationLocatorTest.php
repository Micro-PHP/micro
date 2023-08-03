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

namespace Micro\Plugin\Doctrine\Tests\Unit\Business\Locator;

use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\Doctrine\Business\Locator\AttributeEntityFileConfigurationLocator;
use PHPUnit\Framework\TestCase;

class AttributeEntityFileConfigurationLocatorTest extends TestCase
{
    public function testGetEnabledPluginDirs()
    {
        $kernel = $this->createMock(KernelInterface::class);
        $kernel->expects($this->once())
            ->method('plugins')
            ->willReturn(new \ArrayObject([
                new \stdClass(),
            ]))
        ;

        $locator = new AttributeEntityFileConfigurationLocator($kernel);
        $this->assertEquals([], $locator->getEnabledPluginDirs());
    }
}
