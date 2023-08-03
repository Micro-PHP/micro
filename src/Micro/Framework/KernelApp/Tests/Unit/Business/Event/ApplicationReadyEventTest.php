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

namespace Micro\Framework\KernelApp\Tests\Unit\Business\Event;

use Micro\Framework\KernelApp\AppKernelInterface;
use Micro\Framework\KernelApp\Business\Event\ApplicationReadyEvent;
use PHPUnit\Framework\TestCase;

class ApplicationReadyEventTest extends TestCase
{
    private ApplicationReadyEvent $evt;

    private AppKernelInterface $kernel;

    protected function setUp(): void
    {
        $this->kernel = $this->createMock(AppKernelInterface::class);

        $this->evt = new ApplicationReadyEvent($this->kernel, 'dev');
    }

    public function testEnvironment()
    {
        $this->assertEquals('dev', $this->evt->environment());
    }

    public function testSystemEnvironment()
    {
        $this->assertEquals(\PHP_SAPI, $this->evt->systemEnvironment());
    }

    public function testKernel()
    {
        $this->assertEquals($this->kernel, $this->evt->kernel());
    }
}
