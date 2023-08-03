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
use Micro\Plugin\HttpMiddleware\Business\Middleware\MiddlewareLocator;
use Micro\Plugin\HttpMiddleware\Plugin\HttpMiddlewareOrderedPluginInterface;
use Micro\Plugin\HttpMiddleware\Plugin\HttpMiddlewarePluginInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class MiddlewareLocatorTest extends TestCase
{
    /** @var KernelInterface */
    private $kernel;

    /** @var MiddlewareLocator */
    private $locator;

    protected function setUp(): void
    {
        $this->kernel = $this->createMock(KernelInterface::class);
        $this->locator = new MiddlewareLocator($this->kernel);
    }

    public function testLocate()
    {
        $request = Request::create('/one/two/three/1/success');

        $mc = $this->createMiddlewareCollection($request);
        $this->kernel->expects($this->once())
            ->method('plugins')
            ->willReturn($mc);

        $located = 0;
        foreach ($this->locator->locate($request) as $middleware) {
            ++$located;

            $this->assertInstanceOf(HttpMiddlewarePluginInterface::class, $middleware);
        }

        $this->assertEquals(5, $located);
    }

    public function middlewareCollectionConfig(): array
    {
        return [
            // Success
            ['^/one/two', 3, ['gEt', 'PoSt']],
            ['/three', 1, ['get']],
            ['^/one', null, ['get', 'put']],
            ['^/one/(\b[a-z]+)/three', 2, ['get']],
            ['^/One/(\b[a-z]+)/ThreE/(\d+)/success', 4, ['get']],

            // will no executed

            ['^/one/two', 3, ['PoSt']],
            ['/three', 1, ['put']],
            ['^/one', null, ['patch']],
            ['^/one/(\b[a-z]+)/three', 2, ['put']],
            ['^/One/(\b[a-z]+)/ThreE/(\d+)/success', 4, ['put']],

            ['^/one$', null, ['get']],
            ['/none', null, ['get']],
            ['/(\d+)/$', null, ['get']],
            ['^/one/(\b[a-z]+)/three/four', 2, ['get']],
            ['^/one/two/three/four', null, ['get']],
            ['/one/two/three/four/', null, ['get']],
        ];
    }

    protected function createMiddlewareCollection(Request $request)
    {
        $config = $this->middlewareCollectionConfig();

        $middlewares = [];

        foreach ($config as $mc) {
            $middlewares[] = $this->createMiddlewareObj(
                $mc[2],
                $mc[0],
                $mc[1],
            );
        }

        return new \ArrayObject($middlewares);
    }

    protected function createMiddlewareObj(array $methods, string $path, int|null $priority)
    {
        if (!$priority) {
            $middleware = $this->createMock(HttpMiddlewarePluginInterface::class);
        } else {
            $middleware = $this->createMock(HttpMiddlewareOrderedPluginInterface::class);
            $middleware->method('getMiddlewarePriority')->willReturn($priority);
        }

        $middleware
            ->expects($this->once())
            ->method('getRequestMatchMethods')
            ->willReturn($methods);

        $middleware
            ->method('getRequestMatchPath')
            ->willReturn($path);

        return $middleware;
    }
}
