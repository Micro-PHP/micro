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

use Micro\Plugin\Redis\Business\Redis\RedisManagerInterface;
use Micro\Plugin\Redis\Facade\RedisFacade;
use PHPUnit\Framework\TestCase;

class RedisFacadeTest extends TestCase
{
    public function testGetClient()
    {
        $manager = $this->createMock(RedisManagerInterface::class);
        $manager->expects($this->once())->method('getClient')->with('test');

        $facade = new RedisFacade(
            $manager
        );

        $facade->getClient('test');
    }
}
