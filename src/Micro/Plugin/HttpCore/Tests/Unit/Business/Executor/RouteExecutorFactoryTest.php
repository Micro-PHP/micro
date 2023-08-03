<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit\Business\Executor;

use Micro\Framework\DependencyInjection\ContainerRegistryInterface;
use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorFactory;
use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorInterface;
use Micro\Plugin\HttpCore\Business\Matcher\UrlMatcherFactoryInterface;
use Micro\Plugin\HttpCore\Business\Response\Callback\ResponseCallbackFactoryInterface;
use Micro\Plugin\HttpCore\Business\Response\Transformer\ResponseTransformerFactoryInterface;
use PHPUnit\Framework\TestCase;

class RouteExecutorFactoryTest extends TestCase
{
    public function testCreate()
    {
        $routeExecutorFactory = new RouteExecutorFactory(
            $this->createMock(UrlMatcherFactoryInterface::class),
            $this->createMock(ContainerRegistryInterface::class),
            $this->createMock(ResponseCallbackFactoryInterface::class),
            $this->createMock(ResponseTransformerFactoryInterface::class),
        );

        $this->assertInstanceOf(
            RouteExecutorInterface::class,
            $routeExecutorFactory->create(),
        );
    }
}
