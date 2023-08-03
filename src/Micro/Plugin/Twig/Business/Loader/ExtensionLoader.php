<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Twig\Business\Loader;

use Micro\Plugin\Twig\Plugin\TwigExtensionPluginInterface;
use Twig\Environment;

class ExtensionLoader implements LoaderInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(Environment $environment, object $plugin): void
    {
        if (!$plugin instanceof TwigExtensionPluginInterface) {
            return;
        }

        $this->provideExtensions($environment, $plugin);
    }

    protected function provideExtensions(Environment $environment, TwigExtensionPluginInterface $extensionProvider): void
    {
        foreach ($extensionProvider->provideTwigExtensions() as $extension) {
            $environment->addExtension($extension);
        }
    }
}
