<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Locator\Locator;

use Micro\Framework\Kernel\KernelInterface;
use Symfony\Component\Finder\Finder;

class Locator implements LocatorInterface
{
    /**
     * @var array<class-string>
     */
    private array $locatedClasses;

    public function __construct(
        private readonly KernelInterface $kernel
    ) {
        $this->locatedClasses = [];
    }

    public function lookup(string $classOrInterfaceName): iterable
    {
        $isInterface = interface_exists($classOrInterfaceName);

        if (!$isInterface && !class_exists($classOrInterfaceName)) {
            return;
        }

        foreach ($this->kernel->plugins() as $plugin) {
            $reflection = $this->createReflectionClass($plugin);
            foreach ($this->getPluginClasses($reflection) as $pluginInternalClassName) {
                $pluginClassReflection = $this->createReflectionClass($pluginInternalClassName);

                if ($isInterface) {
                    if (!\in_array($classOrInterfaceName, $pluginClassReflection->getInterfaceNames())) {
                        continue;
                    }
                    /*
                     * @phpstan-ignore-next-line
                     */
                    yield $pluginInternalClassName;

                    continue;
                }

                if (!$pluginClassReflection->isSubclassOf($classOrInterfaceName)) {
                    continue;
                }

                /*
                 * @phpstan-ignore-next-line
                 */
                yield $pluginInternalClassName;
            }
        }

        $this->locatedClasses = [];
    }

    /**
     * @template T of object
     *
     * @param \ReflectionClass<T> $reflection
     *
     * @return \Generator<class-string>
     */
    protected function getPluginClasses(\ReflectionClass $reflection): \Generator
    {
        $filename = $reflection->getFileName();
        if (!$filename) {
            return;
        }

        $pluginBasePath = \dirname($filename);
        $pluginNamespace = $reflection->getNamespaceName();
        $finder = new Finder();
        try {
            $finder
                ->in($pluginBasePath.'/**')
                ->name('*.php')
                ->notName('*Interface.php');
        } catch (\Throwable $exception) {
            return;
        }

        foreach ($finder as $splFileInfo) {
            $relative = str_replace($pluginBasePath, '', (string) $splFileInfo);
            $namespaceRelative = str_replace('/', '\\', $relative);

            $file = str_replace('.php', '', $pluginNamespace.$namespaceRelative);

            if (\in_array($file, $this->locatedClasses) || !class_exists($file)) {
                continue;
            }

            $this->locatedClasses[] = $file;

            yield $file;
        }
    }

    /**
     * @template T of Object
     *
     * @psalm-param  class-string<T>|T $objectOrClass
     *
     * @return \ReflectionClass<T>
     *
     * @throws \ReflectionException
     */
    protected function createReflectionClass(string|object $objectOrClass): \ReflectionClass
    {
        return new \ReflectionClass($objectOrClass);
    }
}
