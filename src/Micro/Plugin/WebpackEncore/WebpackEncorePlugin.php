<?php

declare(strict_types=1);

/*
 * This file is part of the WebpackEncore plugin for Micro Framework.
 * (c) Oleksii Bulba <oleksii.bulba@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Micro\Plugin\WebpackEncore;

use Micro\Framework\BootConfiguration\Plugin\ConfigurableInterface;
use Micro\Framework\BootConfiguration\Plugin\PluginConfigurationTrait;
use Micro\Framework\BootPluginDependent\Plugin\PluginDependedInterface;
use Micro\Plugin\Twig\Plugin\TwigExtensionPluginInterface;
use Micro\Plugin\Twig\TwigPlugin;
use Micro\Plugin\WebpackEncore\Asset\EntrypointLookup;
use Micro\Plugin\WebpackEncore\Asset\EntrypointLookupInterface;
use Micro\Plugin\WebpackEncore\TagRenderer\TagRenderer;
use Micro\Plugin\WebpackEncore\TagRenderer\TagRendererInterface;
use Micro\Plugin\WebpackEncore\Twig\Extension\EntryFilesTwigExtension;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Twig\Extension\ExtensionInterface;

/**
 * @psalm-suppress ImplementedReturnTypeMismatch
 *
 * @method WebpackEncorePluginConfigurationInterface configuration()
 *
 * @codeCoverageIgnore
 */
class WebpackEncorePlugin implements TwigExtensionPluginInterface, ConfigurableInterface, PluginDependedInterface
{
    use PluginConfigurationTrait;

    public function provideTwigExtensions(): iterable
    {
        yield $this->createEntryFilesTwigExtension();
    }

    public function getDependedPlugins(): iterable
    {
        yield TwigPlugin::class;
    }

    protected function createEntryFilesTwigExtension(): ExtensionInterface
    {
        return new EntryFilesTwigExtension($this->createTagRenderer(), $this->createEntrypointLookup());
    }

    protected function createTagRenderer(): TagRendererInterface
    {
        return new TagRenderer($this->createEntrypointLookup());
    }

    protected function createEntrypointLookup(): EntrypointLookupInterface
    {
        return new EntrypointLookup($this->configuration(), $this->createDecoder());
    }

    protected function createDecoder(): DecoderInterface
    {
        return new JsonDecode([JsonDecode::ASSOCIATIVE => true]);
    }
}
