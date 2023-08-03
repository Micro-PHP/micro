<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpLogger\Tests\Unit\Business\Logger\Formatter;

use Micro\Plugin\HttpLogger\Business\Logger\Formatter\Format\LogFormatterConcreteInterface;
use Micro\Plugin\HttpLogger\Business\Logger\Formatter\LogFormatterFactory;
use Micro\Plugin\HttpLogger\Business\Logger\Formatter\LogFormatterInterface;
use PHPUnit\Framework\TestCase;

class LogFormatterFactoryTest extends TestCase
{
    public function testCreate()
    {
        $factory = new LogFormatterFactory([
            $this->createMock(LogFormatterConcreteInterface::class),
        ]);

        $this->assertInstanceOf(LogFormatterInterface::class, $factory->create('test'));
    }
}
