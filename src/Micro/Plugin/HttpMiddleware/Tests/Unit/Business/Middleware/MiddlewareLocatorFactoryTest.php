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

namespace Micro\Plugin\HttpMiddleware\Tests\Unit\Business\Middleware;

use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\HttpMiddleware\Business\Middleware\MiddlewareLocatorFactory;
use Micro\Plugin\HttpMiddleware\Business\Middleware\MiddlewareLocatorInterface;
use PHPUnit\Framework\TestCase;

class MiddlewareLocatorFactoryTest extends TestCase
{
    public function testCreate()
    {
        $kernel = $this->createMock(KernelInterface::class);
        $factory = new MiddlewareLocatorFactory($kernel);
        $this->assertInstanceOf(MiddlewareLocatorInterface::class, $factory->create());
    }
}
