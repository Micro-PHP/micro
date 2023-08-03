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

namespace Micro\Plugin\DTO\Business\FileLocator;

use Micro\Framework\KernelApp\AppKernelInterface;
use Micro\Plugin\DTO\DTOPluginConfigurationInterface;
use Symfony\Component\Finder\Finder;

readonly class FileLocator implements FileLocatorInterface
{
    /**
     * @param DTOPluginConfigurationInterface $DTOPluginConfiguration
     * @param AppKernelInterface              $appKernel
     */
    public function __construct(
        private DTOPluginConfigurationInterface $DTOPluginConfiguration,
        private AppKernelInterface $appKernel
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function lookup(): array
    {
        $finder = $this->createSymfonyFinder();
        $result = [];

        foreach ($finder as $file) {
            $result[] = $file->getRealPath();
        }

        return array_unique($result);
    }

    /**
     * @return Finder
     */
    protected function createSymfonyFinder(): Finder
    {
        $finder = new Finder();

        $finder
            ->ignoreVCSIgnored(true)
            ->name($this->DTOPluginConfiguration->getSourceFileMask())
        ;

        foreach ($this->createPathList() as $pluginPath) {
            $finder->in($pluginPath);
        }

        return $finder;
    }

    /**
     * @return iterable<string>
     */
    protected function createPathList(): iterable
    {
        foreach ($this->appKernel->plugins() as $plugin) {
            $path = $this->getPluginPathDefinition($plugin);
            if (empty($path)) {
                continue;
            }

            yield $path;
        }

        foreach ($this->DTOPluginConfiguration->getSchemaPaths() as $path) {
            yield $path;
        }
    }

    /**
     * @param object $plugin
     *
     * @return string|null
     */
    protected function getPluginPathDefinition(object $plugin): string|null
    {
        $reflector = new \ReflectionClass($plugin);
        $filename = $reflector->getFileName();
        if (!$filename) {
            return null;
        }

        return \dirname($filename, 2);
    }
}
