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

namespace Micro\Plugin\Twig\Tests\Unit\Business\Loader;

use Micro\Plugin\Twig\Business\Loader\TemplateLoader;
use Micro\Plugin\Twig\Plugin\TwigTemplatePluginInterface;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

class TemplateLoaderTest extends TestCase
{
    /**
     * @param class-string $loaderMock
     *
     * @dataProvider dataProvider
     */
    public function testLoad(string $loaderMock, string|null $exception): void
    {
        if ($exception) {
            $this->expectException($exception);
        }

        $templateLoader = new TemplateLoader();
        $templatePath = [
            '/a',
        ];
        $fakePlugin = new \stdClass();
        $plugin = $this->createMock(TwigTemplatePluginInterface::class);
        $loader = $this->createMock($loaderMock);

        if (FilesystemLoader::class === $loaderMock) {
            $loader
                ->expects($this->once())
                ->method('addPath')
                ->with($templatePath[0], FilesystemLoader::MAIN_NAMESPACE);

            $plugin->expects($this->once())->method('getTwigNamespace')->willReturn(null);
            $plugin->expects($this->once())->method('getTwigTemplatePaths')->willReturn($templatePath);
        }

        $twigEnv = $this->createMock(Environment::class);
        $twigEnv->expects($this->once())->method('getLoader')->willReturn($loader);

        $templateLoader->load($twigEnv, $fakePlugin);
        $templateLoader->load($twigEnv, $plugin);
    }

    public function dataProvider(): array
    {
        return [
            [FilesystemLoader::class, null],
            [LoaderInterface::class, \InvalidArgumentException::class],
        ];
    }
}
