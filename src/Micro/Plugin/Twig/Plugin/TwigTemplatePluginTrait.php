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

namespace Micro\Plugin\Twig\Plugin;

trait TwigTemplatePluginTrait
{
    /**
     * @return string[]
     */
    public function getTwigTemplatePaths(): array
    {
        $classCurrent = new \ReflectionObject($this);
        $filename = $classCurrent->getFileName();

        if (false === $filename) {
            throw new \RuntimeException('Unable to determine path from where to load twig templates.');
        }

        return [
            \dirname($filename).\DIRECTORY_SEPARATOR.'templates',
        ];
    }

    public function getTwigNamespace(): ?string
    {
        $classCurrent = new \ReflectionObject($this);
        if ($classCurrent->isAnonymous()) {
            return null;
        }

        return $classCurrent->getShortName();
    }
}
