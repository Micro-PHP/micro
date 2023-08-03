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

class TwigRenderer implements TwigRendererInterface
{
    public function __construct(
        private readonly EnvironmentFactoryInterface $environmentFactory
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function render(string $templateName, array $arguments): string
    {
        return $this->environmentFactory
            ->create()
            ->load($templateName)
            ->render($arguments);
    }
}
