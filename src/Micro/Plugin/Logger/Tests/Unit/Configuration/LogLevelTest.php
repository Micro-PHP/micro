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

namespace Micro\Plugin\Logger\Tests\Unit\Configuration;

use Micro\Plugin\Logger\Configuration\LogLevel;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel as PsrLogLevel;

class LogLevelTest extends TestCase
{
    public function testLevelMethodReturnsCorrectValue()
    {
        $this->assertEquals(PsrLogLevel::DEBUG, LogLevel::DEBUG->level());
        $this->assertEquals(PsrLogLevel::CRITICAL, LogLevel::CRITICAL->level());
        $this->assertEquals(PsrLogLevel::EMERGENCY, LogLevel::EMERGENCY->level());
        $this->assertEquals(PsrLogLevel::ALERT, LogLevel::ALERT->level());
        $this->assertEquals(PsrLogLevel::ERROR, LogLevel::ERROR->level());
        $this->assertEquals(PsrLogLevel::INFO, LogLevel::INFO->level());
        $this->assertEquals(PsrLogLevel::WARNING, LogLevel::WARNING->level());
        $this->assertEquals(PsrLogLevel::NOTICE, LogLevel::NOTICE->level());
    }

    public function testGetLevelFromStringReturnsCorrectValue()
    {
        $this->assertEquals(LogLevel::DEBUG, LogLevel::getLevelFromString(PsrLogLevel::DEBUG));
        $this->assertEquals(LogLevel::CRITICAL, LogLevel::getLevelFromString(PsrLogLevel::CRITICAL));
        $this->assertEquals(LogLevel::EMERGENCY, LogLevel::getLevelFromString(PsrLogLevel::EMERGENCY));
        $this->assertEquals(LogLevel::ALERT, LogLevel::getLevelFromString(PsrLogLevel::ALERT));
        $this->assertEquals(LogLevel::ERROR, LogLevel::getLevelFromString(PsrLogLevel::ERROR));
        $this->assertEquals(LogLevel::INFO, LogLevel::getLevelFromString(PsrLogLevel::INFO));
        $this->assertEquals(LogLevel::WARNING, LogLevel::getLevelFromString(PsrLogLevel::WARNING));
        $this->assertEquals(LogLevel::NOTICE, LogLevel::getLevelFromString(PsrLogLevel::NOTICE));
    }

    public function testGetLevelFromStringThrowsExceptionForInvalidValue()
    {
        $this->expectException(\RuntimeException::class);
        LogLevel::getLevelFromString('invalid_value');
    }
}
