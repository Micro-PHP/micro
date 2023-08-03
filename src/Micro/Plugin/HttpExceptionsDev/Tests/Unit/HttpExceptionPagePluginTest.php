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

namespace Micro\Plugin\HttpExceptionsDev\Tests\Unit;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Framework\KernelApp\AppKernel;
use Micro\Plugin\HttpCore\Business\Route\RouteBuilderInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use Micro\Plugin\HttpCore\Exception\HttpException;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class HttpExceptionPagePluginTest extends TestCase
{
    protected function createKernel(string $env): AppKernel
    {
        $kernel = new AppKernel(
            new DefaultApplicationConfiguration([
                'BASE_PATH' => __DIR__,
                'APP_ENV' => $env,
            ]),
            [
                End2EndTest::class,
            ]
        );

        $kernel->run();

        return $kernel;
    }

    public function testDecorated()
    {
        $kernel = $this->createKernel('dev');
        $request = Request::create('/');

        $httpFacade = $kernel->container()->get(HttpFacadeInterface::class);

        $route = $httpFacade->match($request);
        $this->assertInstanceOf(RouteInterface::class, $route);
        $this->assertEquals('home', $route->getName());
        $this->assertEquals('/', $route->getUri());

        $routeBuilder = $httpFacade->createRouteBuilder();
        $this->assertInstanceOf(RouteBuilderInterface::class, $routeBuilder);

        $declaredRoutes = $httpFacade->getDeclaredRoutesNames();
        $this->assertEquals([
            'route_500',
            'route_500_1',
            'home',
        ], $declaredRoutes);

        $this->assertEquals('/', $httpFacade->generateUrlByRouteName('home'));
    }

    /**
     * @dataProvider dataProviderException
     */
    public function testExceptionResponse(string $env, string $uri, bool $isFlush, mixed $result, string $format)
    {
        $kernel = $this->createKernel($env);
        $request = Request::create($uri);
        $request->request->set('_format', $format);

        $isDev = str_starts_with($env, 'dev');
        preg_match('/\d+/', $uri, $match);
        $exceptionCode = (int) $match[0];

        $this->expectException(HttpException::class);
        $this->expectExceptionCode($exceptionCode);

        ob_start();

        try {
            $response = $kernel->container()->get(HttpFacadeInterface::class)
                ->execute($request, $isFlush);

            $flushedContent = ob_get_clean();
        } catch (HttpException $httpException) {
            $flushedContent = ob_get_clean();

            if ($isFlush) {
                if ('json' === $format) {
                    $this->assertJson($flushedContent);
                }

                if ('html' === $format) {
                    $this->assertStringStartsWith('<!--', $flushedContent);
                    $this->assertStringEndsWith('-->', $flushedContent);
                }
            }

            throw $httpException;
        }

        $responseContent = $response->getContent();
        if ('html' === $format) {
            $this->assertStringStartsWith('<!--', $responseContent);
            $this->assertStringEndsWith('-->', $responseContent);
        }

        if ('json' === $format) {
            $this->assertJson($responseContent);
        }

        $this->assertStringEndsWith($responseContent, $flushedContent);
        $this->assertStringStartsWith($responseContent, $flushedContent);
    }

    /**
     * @dataProvider dataProviderSuccess
     */
    public function testSuccessResponse(string $env, string $uri, bool $isFlush, mixed $result, string $format)
    {
        $kernel = $this->createKernel($env);
        $request = Request::create($uri);
        $request->request->set('_format', $format);

        ob_start();

        $response = $kernel->container()->get(HttpFacadeInterface::class)
            ->execute($request, $isFlush);

        $responseFlushedContent = ob_get_clean();

        $this->assertEquals($isFlush ? $result : '', $responseFlushedContent);
        $this->assertEquals($result, $response->getContent());
    }

    public static function dataProviderSuccess(): array
    {
        return [
            ['dev', '/', true, 'Hello, world', 'html'],
            ['develop', '/', false, 'Hello, world', 'html'],
            ['dev-', '/', true, 'Hello, world', 'html'],
            ['test', '/', false, 'Hello, world', 'html'],

            // JSON validation
            ['dev', '/', true, 'Hello, world', 'json'],
            ['develop', '/', false, 'Hello, world', 'json'],
            ['dev-', '/', true, 'Hello, world', 'json'],
            ['test', '/', false, 'Hello, world', 'json'],
        ];
    }

    public static function dataProviderException(): array
    {
        return [
            ['dev', '/404', true, null, 'html'],
            ['develop', '/404', false, 'Not Found.', 'html'],
            ['dev-', '/404', true, null, 'html'],
            ['test', '/404', false, 'Not Found.', 'html'],

            ['dev', '/500', true, null, 'html'],
            ['develop', '/500', false, 'Hello, i\'m 500 exception', 'html'],
            ['dev-', '/500', true, null, 'html'],
            ['test', '/500', false, 'Hello, i\'m 500 exception', 'html'],

            ['dev', '/500_1', true, null, 'html'],
            ['develop', '/500_1', false, 'Hello, i\'m 500_1 exception', 'html'],
            ['dev-', '/500_1', true, null, 'html'],
            ['test', '/500_1', false, 'Hello, i\'m 500_1 exception', 'html'],

            // Json validation
            ['dev', '/404', true, null, 'json'],
            ['develop', '/404', false, 'Not Found.', 'json'],
            ['dev-', '/404', true, null, 'html'],
            ['test', '/404', false, 'Not Found.', 'json'],

            ['dev', '/500', true, null, 'json'],
            ['develop', '/500', false, 'Hello, i\'m 500 exception', 'json'],
            ['dev-', '/500', true, null, 'json'],
            ['test', '/500', false, 'Hello, i\'m 500 exception', 'json'],

            ['dev', '/500_1', true, null, 'json'],
            ['develop', '/500_1', false, 'Hello, i\'m 500_1 exception', 'json'],
            ['dev-', '/500_1', true, null, 'json'],
            ['test', '/500_1', false, 'Hello, i\'m 500_1 exception', 'json'],
        ];
    }
}
