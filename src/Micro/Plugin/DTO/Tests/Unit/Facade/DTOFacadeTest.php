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

namespace Micro\Plugin\DTO\Tests\Unit\Facade;

use Micro\Plugin\DTO\Business\Generator\GeneratorFactoryInterface;
use Micro\Plugin\DTO\Business\Generator\GeneratorInterface;
use Micro\Plugin\DTO\Facade\DTOFacade;
use PHPUnit\Framework\TestCase;

class DTOFacadeTest extends TestCase
{
    public function testGenerate()
    {
        $generator = $this->createMock(GeneratorInterface::class);
        $generator
            ->expects($this->once())->method('generate');

        $factory = $this->createMock(GeneratorFactoryInterface::class);
        $factory->expects($this->once())->method('create')->willReturn($generator);

        $facade = new DTOFacade($factory);
        $facade->generate();
    }
}
