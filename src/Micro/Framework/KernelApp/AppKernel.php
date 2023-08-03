<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\KernelApp;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootConfiguration\Boot\ConfigurationProviderBootLoader;
use Micro\Framework\BootPluginDependent\Boot\DependedPluginsBootLoader;
use Micro\Framework\BootDependency\Boot\DependencyProviderBootLoader;
use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Framework\Kernel\KernelBuilder;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\Kernel\Plugin\PluginBootLoaderInterface;
use Micro\Framework\KernelApp\Business\KernelActionProcessorInterface;
use Micro\Framework\KernelApp\Business\KernelRunActionProcessor;
use Micro\Framework\KernelApp\Business\KernelTerminateActionProcessor;
use Micro\Plugin\EventEmitter\EventEmitterPlugin;
use Micro\Plugin\Locator\LocatorPlugin;

class AppKernel implements AppKernelInterface
{
    private bool $isTerminated;

    private bool $isStarted;

    private ?KernelInterface $kernel;

    /**
     * @var PluginBootLoaderInterface[]
     */
    private array $additionalBootLoaders = [];

    /**
     * @param ApplicationConfigurationInterface|array<string, string> $configuration
     * @param class-string[]                                          $plugins
     */
    public function __construct(
        private readonly ApplicationConfigurationInterface|array $configuration = [],
        private array $plugins = [],
        private readonly string $environment = 'dev'
    ) {
        $this->kernel = null;
        $this->isTerminated = false;
        $this->isStarted = false;
    }

    /**
     * {@inheritDoc}
     */
    public function container(): Container
    {
        return $this->kernel()->container();
    }

    /**
     * {@inheritDoc}
     */
    public function plugins(string $interfaceInherited = null): \Traversable
    {
        return $this->kernel()->plugins($interfaceInherited);
    }

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        if ($this->isStarted) {
            return;
        }

        $this->kernel = $this->createKernel();

        $this->kernel->run();

        $this->createInitActionProcessor()->process($this);

        $this->isStarted = true;
    }

    /**
     * {@inheritDoc}
     */
    public function terminate(): void
    {
        if ($this->isTerminated || !$this->isStarted) {
            return;
        }

        $this->createTerminateActionProcessor()->process($this);

        $this->isTerminated = true;
    }

    public function environment(): string
    {
        return $this->environment;
    }

    public function isDevMode(): bool
    {
        return str_starts_with($this->environment(), 'dev');
    }

    /**
     * {@inheritDoc}
     */
    public function addBootLoader(PluginBootLoaderInterface $bootLoader): self
    {
        $this->additionalBootLoaders[] = $bootLoader;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function loadPlugin(string $applicationPluginClass): void
    {
        $this->kernel()->loadPlugin($applicationPluginClass);
    }

    protected function createKernel(): KernelInterface
    {
        $container = new Container();
        $plugins = $this->plugins;
        $this->plugins = [];

        return $this
            ->createKernelBuilder()
            ->setContainer($container)
            ->addBootLoaders($this->createBootLoaderCollection($container))
            ->setApplicationPlugins(array_unique([
                    EventEmitterPlugin::class,
                    LocatorPlugin::class,
                    ...$plugins,
                ])
            )
            ->build();
    }

    protected function kernel(): KernelInterface
    {
        if (!$this->kernel) {
            $trace = debug_backtrace();
            $caller = $trace[1];
            /**
             * @var string $cc
             *
             * @phpstan-ignore-next-line
             *
             * @psalm-suppress PossiblyUndefinedArrayOffset
             */
            $cc = $caller['class'];
            $cm = $caller['function'];

            throw new \RuntimeException(sprintf('Method %s::%s can not be called before %s::run() execution.', $cc, $cm, KernelInterface::class));
        }

        return $this->kernel;
    }

    protected function createKernelBuilder(): KernelBuilder
    {
        return new KernelBuilder();
    }

    protected function createInitActionProcessor(): KernelActionProcessorInterface
    {
        return new KernelRunActionProcessor();
    }

    protected function createTerminateActionProcessor(): KernelActionProcessorInterface
    {
        return new KernelTerminateActionProcessor();
    }

    /**
     * @return PluginBootLoaderInterface[]
     */
    protected function createBootLoaderCollection(Container $container): array
    {
        $bl = $this->additionalBootLoaders;

        $this->additionalBootLoaders = [];

        return [
            new ConfigurationProviderBootLoader($this->configuration),
            new DependencyProviderBootLoader($container),
            new DependedPluginsBootLoader($this),
            ...$bl,
        ];
    }

    public function setBootLoaders(iterable $bootLoaders): KernelInterface
    {
        $this->kernel()->setBootLoaders($bootLoaders);

        return $this;
    }
}
