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

use Micro\Plugin\Twig\Business\Loader\ExtensionLoader;
use Micro\Plugin\Twig\Plugin\TwigExtensionPluginInterface;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Extension\ExtensionInterface;

class ExtensionLoaderTest extends TestCase
{
    public function testLoad()
    {
        // TwigExtensionPluginInterface
        $loader = new ExtensionLoader();
        $env = $this->createMock(Environment::class);

        $objectInvalid = new \stdClass();

        $loader->load($env, $objectInvalid);

        $extension = $this->createMock(ExtensionInterface::class);
        $objectValid = $this->createMock(TwigExtensionPluginInterface::class);

        $env
            ->expects($this->once())
            ->method('addExtension')
            ->with($extension);

        $objectValid
            ->expects($this->once())
            ->method('provideTwigExtensions')
            ->willReturn(new \ArrayObject(
                [$extension]
            ));

        $loader->load($env, $objectValid);
    }
}
