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

namespace Micro\Plugin\DTO\Tests\Unit\Console;

use Micro\Plugin\DTO\Console\GenerateDTOCommand;
use Micro\Plugin\DTO\Facade\DTOFacadeInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateDTOCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $facade = $this->createMock(DTOFacadeInterface::class);
        $facade->expects($this->once())->method('generate');

        $command = new GenerateDTOCommand(
            $facade
        );
        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $command->run($input, $output);
    }

    public function testExecuteException(): void
    {
        $errMsg = 'Hello, World';
        $facade = $this->createMock(DTOFacadeInterface::class);
        $facade->expects($this->once())->method('generate')->willThrowException(new \RuntimeException($errMsg));

        $command = new GenerateDTOCommand(
            $facade
        );

        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage($errMsg);

        $command->run($input, $output);
    }
}
