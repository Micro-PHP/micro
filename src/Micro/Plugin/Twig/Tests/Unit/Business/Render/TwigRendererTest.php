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

namespace Micro\Plugin\Twig\Tests\Unit\Business\Render;

use Micro\Plugin\Twig\Business\Environment\EnvironmentFactoryInterface;
use Micro\Plugin\Twig\Business\Render\TwigRenderer;
use Micro\Plugin\Twig\Business\Render\TwigRendererInterface;
use PHPUnit\Framework\TestCase;

class TwigRendererTest extends TestCase
{
    public function testRender(): void
    {
        $factory = $this->createMock(EnvironmentFactoryInterface::class);
        $renderer = new TwigRenderer($factory);

        $this->assertInstanceOf(TwigRendererInterface::class, $renderer);
    }
}
