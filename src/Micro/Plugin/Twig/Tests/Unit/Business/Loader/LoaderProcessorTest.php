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

use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\Twig\Business\Loader\LoaderInterface;
use Micro\Plugin\Twig\Business\Loader\LoaderProcessor;
use Micro\Plugin\Twig\Plugin\TwigTemplatePluginInterface;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Extension\ExtensionInterface;

class LoaderProcessorTest extends TestCase
{
    public function testLoad()
    {
        $kernel = $this->createMock(KernelInterface::class);
        $kernel
            ->expects($this->once())
            ->method('plugins')
            ->willReturn(new \ArrayObject([
                new \stdClass(),
                $this->createMock(ExtensionInterface::class),
                $this->createMock(TwigTemplatePluginInterface::class),
            ]));

        $loader1 = $this->createMock(LoaderInterface::class);
        $loader2 = $this->createMock(LoaderInterface::class);

        $loaderProcessor = new LoaderProcessor(
            $kernel,
            new \ArrayObject([
                $loader1, $loader2,
            ]),
        );

        $twigEnv = $this->createMock(Environment::class);
        $loaderProcessor->load($twigEnv);
    }
}
