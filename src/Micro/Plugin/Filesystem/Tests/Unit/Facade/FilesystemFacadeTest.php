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

namespace Micro\Plugin\Filesystem\Tests\Unit\Facade;

use Micro\Plugin\Filesystem\Facade\FilesystemFacade;
use PHPUnit\Framework\TestCase;

class FilesystemFacadeTest extends TestCase
{
    public function testCreateFsOperator()
    {
        $facade = new FilesystemFacade();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches('/adapter cannot be initialized./');

        $facade->createFsOperator('test-provider');
    }
}
