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

namespace Micro\Plugin\Doctrine\Tests\Unit\Configuration;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\Doctrine\Configuration\EntityManagerConfiguration;
use PHPUnit\Framework\TestCase;

class EntityManagerConfigurationTest extends TestCase
{
    public function testGetDriverUnavailableConfiguration()
    {
        $cfg = new EntityManagerConfiguration(new DefaultApplicationConfiguration(
            ['ORM_TEST_DRIVER' => 'not_registered_driver']
        ), 'test');

        $this->expectException(\InvalidArgumentException::class);
        $cfg->getDriverConfiguration();
    }
}
