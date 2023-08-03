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

use Micro\Plugin\Twig\Plugin\TwigTemplatePluginInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Loader\FilesystemLoader;

class TemplateLoader implements LoaderInterface
{
    /**
     * @throws LoaderError
     */
    public function load(Environment $environment, object $plugin): void
    {
        if (!($plugin instanceof TwigTemplatePluginInterface)) {
            return;
        }

        /** @var FilesystemLoader $loader */
        $loader = $environment->getLoader();
        if (!($loader instanceof FilesystemLoader)) {
            throw new \InvalidArgumentException(sprintf('The loader supports only %s', FilesystemLoader::class));
        }

        $namespace = $plugin->getTwigNamespace();
        $paths = $plugin->getTwigTemplatePaths();

        $this->registerTemplates($loader, $paths, $namespace);
    }

    /**
     * @param string[] $paths
     *
     * @throws LoaderError
     */
    protected function registerTemplates(FilesystemLoader $loader, array $paths, string $namespace = null): void
    {
        if (null === $namespace) {
            $namespace = FilesystemLoader::MAIN_NAMESPACE;
        }

        foreach ($paths as $path) {
            $loader->addPath($path, $namespace);
        }
    }
}
