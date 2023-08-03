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

namespace Micro\Plugin\Cache\Tests\Unit\Communication\Cli;

use Micro\Plugin\Cache\Communication\Cli\ClearCacheCommand;
use Micro\Plugin\Cache\Facade\CacheFacadeInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCacheCommandTest extends TestCase
{
    public function testCommand(): void
    {
        $cacheFacade = $this->createMock(CacheFacadeInterface::class);
        $cmd = new ClearCacheCommand(
            $cacheFacade
        );

        $this->assertIsString($cmd->getDescription());
        $this->assertIsString($cmd->getHelp());

        $input = $this->createMock(InputInterface::class);
        $input
            ->expects($this->once())
            ->method('getArgument')
            ->with('pools')
            ->willReturn(['test'])
        ;
        $output = $this->createMock(OutputInterface::class);
        $this->assertEquals(0, $cmd->run($input, $output));
    }
}
