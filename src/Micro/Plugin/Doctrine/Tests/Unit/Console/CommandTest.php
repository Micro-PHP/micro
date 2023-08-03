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

namespace Micro\Plugin\Doctrine\Tests\Unit\Console;

use Micro\Plugin\Doctrine\Console\CollectionRegionCommand;
use Micro\Plugin\Doctrine\Console\CreateCommand;
use Micro\Plugin\Doctrine\Console\DropCommand;
use Micro\Plugin\Doctrine\Console\EntityRegionCommand;
use Micro\Plugin\Doctrine\Console\GenerateProxiesCommand;
use Micro\Plugin\Doctrine\Console\InfoCommand;
use Micro\Plugin\Doctrine\Console\MappingDescribeCommand;
use Micro\Plugin\Doctrine\Console\MetadataCommand;
use Micro\Plugin\Doctrine\Console\QueryCommand;
use Micro\Plugin\Doctrine\Console\ResultCommand;
use Micro\Plugin\Doctrine\Console\RunDqlCommand;
use Micro\Plugin\Doctrine\Console\UpdateCommand;
use Micro\Plugin\Doctrine\Console\ValidateSchemaCommand;
use Micro\Plugin\Doctrine\DoctrineFacadeInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;

class CommandTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testCmd(string $cmd)
    {
        $facade = $this->createMock(DoctrineFacadeInterface::class);

        $obj = new $cmd($facade);
        $this->assertInstanceOf(Command::class, $obj);
    }

    public static function dataProvider(): array
    {
        return [
            [CollectionRegionCommand::class],
            [CreateCommand::class],
            [DropCommand::class],
            [EntityRegionCommand::class],
            [GenerateProxiesCommand::class],
            [InfoCommand::class],
            [MappingDescribeCommand::class],
            [MetadataCommand::class],
            [QueryCommand::class],
            [ResultCommand::class],
            [RunDqlCommand::class],
            [UpdateCommand::class],
            [ValidateSchemaCommand::class],
        ];
    }
}
