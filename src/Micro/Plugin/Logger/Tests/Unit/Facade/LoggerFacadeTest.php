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

namespace Micro\Plugin\Logger\Tests\Unit\Facade;

use Micro\Plugin\Logger\Business\Provider\LoggerProviderInterface;
use Micro\Plugin\Logger\Facade\LoggerFacade;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LoggerFacadeTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testGetLogger(string|null $loggerName)
    {
        $provider = $this->createMock(LoggerProviderInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $provider
            ->expects($this->once())
            ->method('getLogger')
            ->with($loggerName ?? 'default')
            ->willReturn($logger);

        $facade = new LoggerFacade($provider);

        $this->assertSame($logger, $facade->getLogger($loggerName));
    }

    public function dataProvider()
    {
        return [
            ['test'],
            [null],
        ];
    }
}
