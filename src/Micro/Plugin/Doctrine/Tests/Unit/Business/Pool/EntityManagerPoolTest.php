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

namespace Micro\Plugin\Doctrine\Tests\Unit\Business\Pool;

use Micro\Plugin\Doctrine\Business\EntityManager\EntityManagerFactoryInterface;
use Micro\Plugin\Doctrine\Business\Pool\EntityManagerPool;
use Micro\Plugin\Doctrine\Business\Pool\EntityManagerPoolInterface;
use PHPUnit\Framework\TestCase;

class EntityManagerPoolTest extends TestCase
{
    private EntityManagerPoolInterface $pool;
    private EntityManagerFactoryInterface $emFactory;

    protected function setUp(): void
    {
        $this->emFactory = $this->createMock(EntityManagerFactoryInterface::class);

        $this->pool = new EntityManagerPool(
            $this->emFactory,
            [],
        );
    }

    public function testGetDefaultManager()
    {
        $this->expectException(\LogicException::class);
        $this->pool->getDefaultManager();
    }

    public function testGetManager()
    {
        $this->emFactory
            ->expects($this->once())
            ->method('create')
            ->with('default');

        $manager = $this->pool->getManager('default');
        $cached = $this->pool->getManager('default');

        $this->assertEquals($manager, $cached);
    }
}
