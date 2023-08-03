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

use Twig\Error\Error;

interface TwigRendererInterface
{
    /**
     * @param array<string, mixed> $arguments
     *
     * @throws Error
     */
    public function render(string $templateName, array $arguments): string;
}
