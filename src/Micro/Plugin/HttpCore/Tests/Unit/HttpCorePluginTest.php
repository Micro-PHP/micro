<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Framework\KernelApp\AppKernel;
use Micro\Plugin\HttpCore\Exception\HttpException;
use Micro\Plugin\HttpCore\Facade\HttpFacadeInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class HttpCorePluginTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testPlugin(string $parameter)
    {
        $config = new DefaultApplicationConfiguration([]);

        $kernel = new AppKernel(
            $config,
            [
                HttpTestPlugin::class,
            ],
            'dev',
        );

        $kernel->run();
        $request = Request::create('/'.$parameter);

        $exceptedException = !\in_array($parameter, ['success', 'runtime_transformed']);

        if ($exceptedException) {
            $this->expectException(HttpException::class);
        }

        try {
            $response = $kernel
                ->container()
                ->get(HttpFacadeInterface::class)
                ->execute($request);
        } catch (HttpException $exception) {
            throw $exception;
        }

        $this->assertEquals($parameter, $response->getContent());
    }

    public static function dataProvider(): array
    {
        return [
            ['success'],
            ['runtime_transformed'],
            ['exception'],
            ['bad_request'],
            ['null'],
        ];
    }
}
