<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Twig\Business\Render;

use Micro\Plugin\Twig\Business\Environment\EnvironmentFactoryInterface;

class TwigRendererFactory implements TwigRendererFactoryInterface
{
    public function __construct(private EnvironmentFactoryInterface $environmentFactory)
    {
    }

    public function create(): TwigRendererInterface
    {
        return new TwigRenderer($this->environmentFactory);
    }
}
