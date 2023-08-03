<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Twig;

use Micro\Plugin\Twig\Business\Render\TwigRendererFactoryInterface;

readonly class TwigFacade implements TwigFacadeInterface
{
    public function __construct(
        private TwigRendererFactoryInterface $twigRendererFactory
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function render(string $templateName, array $arguments = []): string
    {
        return $this->twigRendererFactory
            ->create()
            ->render($templateName, $arguments);
    }
}
