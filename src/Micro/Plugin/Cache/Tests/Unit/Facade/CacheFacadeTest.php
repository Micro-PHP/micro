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

namespace Micro\Plugin\Cache\Tests\Unit\Facade;

use Micro\Plugin\Cache\Business\Pool\CachePoolFactoryInterface;
use Micro\Plugin\Cache\Facade\CacheFacade;
use PHPUnit\Framework\TestCase;

class CacheFacadeTest extends TestCase
{
    public function testGetCache()
    {
        $factory = $this->createMock(CachePoolFactoryInterface::class);
        $factory
            ->expects($this->once())
            ->method('create');

        $facade = new CacheFacade($factory);

        $facade->getCachePsr16('test');
        $facade->getCachePsr16('test2');
    }
}
