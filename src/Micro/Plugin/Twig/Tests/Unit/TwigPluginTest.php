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

namespace Micro\Plugin\Twig\Tests\Unit;

use Micro\Component\DependencyInjection\Autowire\ContainerAutowire;
use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\Twig\TwigFacadeInterface;
use Micro\Plugin\Twig\TwigPlugin;
use Micro\Plugin\Twig\TwigPluginConfiguration;
use Micro\Plugin\Twig\TwigPluginConfigurationInterface;
use PHPUnit\Framework\TestCase;

class TwigPluginTest extends TestCase
{
    private TwigPlugin $plugin;

    private TwigPluginConfigurationInterface $pluginConfiguration;

    private ApplicationConfigurationInterface $applicationConfiguration;

    protected function setUp(): void
    {
        $this->applicationConfiguration = $this->createMock(ApplicationConfigurationInterface::class);
        $this->pluginConfiguration = new TwigPluginConfiguration($this->applicationConfiguration);
        $this->plugin = new TwigPlugin();
        $this->plugin->setConfiguration($this->pluginConfiguration);
    }

    public function testProvideDependencies()
    {
        $kernel = $this->createMock(KernelInterface::class);
        $container = new ContainerAutowire(new Container());
        $container->register(KernelInterface::class, fn () => $kernel);
        $this->plugin->provideDependencies($container);
        $this->assertInstanceOf(TwigFacadeInterface::class, $container->get(TwigFacadeInterface::class));
    }
}
