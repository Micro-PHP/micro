<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit\Business\Response;

use Micro\Framework\Autowire\AutowireHelperFactoryInterface;
use Micro\Plugin\HttpCore\Business\Response\Callback\ResponseCallbackFactory;
use Micro\Plugin\HttpCore\Business\Response\Callback\ResponseCallbackInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use PHPUnit\Framework\TestCase;

class ResponseCallbackFactoryTest extends TestCase
{
    public function testCreate()
    {
        $responseCallbackFactory = new ResponseCallbackFactory(
            $this->createMock(AutowireHelperFactoryInterface::class),
        );

        $route = $this->createMock(RouteInterface::class);

        $callback = $responseCallbackFactory->create($route);

        $this->assertInstanceOf(ResponseCallbackInterface::class, $callback);
    }
}
