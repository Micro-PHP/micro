<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit\Business\Matcher;

use Micro\Plugin\HttpCore\Business\Matcher\Route\RouteMatcherFactoryInterface;
use Micro\Plugin\HttpCore\Business\Matcher\UrlMatcherFactory;
use Micro\Plugin\HttpCore\Business\Matcher\UrlMatcherInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteCollectionFactoryInterface;
use PHPUnit\Framework\TestCase;

class UrlMatcherFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new UrlMatcherFactory(
            $this->createMock(RouteCollectionFactoryInterface::class),
            $this->createMock(RouteMatcherFactoryInterface::class)
        );

        $this->assertInstanceOf(UrlMatcherInterface::class, $factory->create());
    }
}
