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

namespace Micro\Plugin\HttpExceptions\Tests\Unit\Business\Executor;

use Micro\Plugin\HttpExceptions\Business\Executor\HttpExceptionExecutorDecoratorFactory;
use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author ChatGPT Jan 9 Version
 */
class HttpExceptionExecutorDecoratorFactoryTest extends TestCase
{
    public function testCreate()
    {
        $decorated = $this->createMock(RouteExecutorInterface::class);
        $factory = new HttpExceptionExecutorDecoratorFactory($decorated);

        $this->assertInstanceOf(RouteExecutorInterface::class, $factory->create());
    }
}
