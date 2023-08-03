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

namespace Micro\Plugin\Doctrine\Tests\Unit;

use Micro\Framework\KernelApp\AppKernel;
use Micro\Plugin\Doctrine\DoctrineFacadeInterface;
use Micro\Plugin\Doctrine\DoctrinePlugin;
use PHPUnit\Framework\TestCase;

class DoctrinePluginTest extends TestCase
{
    public function testSqlitePlugin(): void
    {
        $kernel = new AppKernel(
            [
                'ORM_DEFAULT_DRIVER' => 'pdo_sqlite',
                'ORM_DEFAULT_IN_MEMORY' => true,
            ],
            [DoctrinePlugin::class],
            'dev'
        );

        $kernel->run();
        /** @var DoctrineFacadeInterface $doctrine */
        $doctrine = $kernel->container()->get(DoctrineFacadeInterface::class);
        $manager = $doctrine->getManager();
        $this->assertEquals($manager, $doctrine->getDefaultManager());

        $this->assertTrue($manager->getConnection()->connect());
        $manager->getConnection()->close();
    }
}
