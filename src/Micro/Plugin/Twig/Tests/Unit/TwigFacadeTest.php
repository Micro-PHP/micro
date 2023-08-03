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

namespace Micro\Plugin\Twig\Tests\Unit;

use Micro\Plugin\Twig\Business\Render\TwigRendererFactoryInterface;
use Micro\Plugin\Twig\Business\Render\TwigRendererInterface;
use Micro\Plugin\Twig\TwigFacade;
use Micro\Plugin\Twig\TwigFacadeInterface;
use PHPUnit\Framework\TestCase;

class TwigFacadeTest extends TestCase
{
    private TwigFacadeInterface $twigFacade;

    private TwigRendererFactoryInterface $twigRendererFactory;

    protected function setUp(): void
    {
        $this->twigRendererFactory = $this->createMock(TwigRendererFactoryInterface::class);

        $this->twigFacade = new TwigFacade(
            $this->twigRendererFactory,
        );
    }

    public function testRender()
    {
        $tplName = 'template.twig';
        $exceptedResult = 'template-result';
        $arguments = [
            'a' => 'a',
        ];

        $renderer = $this->createMock(TwigRendererInterface::class);
        $renderer
            ->expects($this->once())
            ->method('render')
            ->with($tplName, $arguments)
            ->willReturn($exceptedResult);

        $this->twigRendererFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($renderer);

        $this->assertEquals($exceptedResult,
            $this->twigFacade->render($tplName, $arguments)
        );
    }
}
