<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Twig\Business\Environment;

use Micro\Plugin\Twig\Business\Loader\LoaderProcessorInterface;
use Micro\Plugin\Twig\TwigPluginConfigurationInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

readonly class EnvironmentFactory implements EnvironmentFactoryInterface
{
    public function __construct(
        private TwigPluginConfigurationInterface $pluginConfiguration,
        private LoaderProcessorInterface $environmentLoaderProcessor
    ) {
    }

    public function create(): Environment
    {
        $twig = $this->createEnvironment();

        $this->environmentLoaderProcessor->load($twig);

        return $twig;
    }

    protected function createEnvironment(): Environment
    {
        return new Environment(
            $this->createLoader(),
            $this->createEnvironmentConfigurationArray()
        );
    }

    protected function createLoader(): LoaderInterface
    {
        return new FilesystemLoader();
    }

    /**
     * @return array<string, mixed>
     */
    protected function createEnvironmentConfigurationArray(): array
    {
        return $this->pluginConfiguration->getConfigurationArray();
    }
}
