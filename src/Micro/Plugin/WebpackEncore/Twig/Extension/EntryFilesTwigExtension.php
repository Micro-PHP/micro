<?php

declare(strict_types=1);

/*
 * This file is part of the WebpackEncore plugin for Micro Framework.
 * (c) Oleksii Bulba <oleksii.bulba@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Micro\Plugin\WebpackEncore\Twig\Extension;

use Micro\Plugin\WebpackEncore\Asset\EntrypointLookupInterface;
use Micro\Plugin\WebpackEncore\TagRenderer\TagRendererInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @codeCoverageIgnore
 */
class EntryFilesTwigExtension extends AbstractExtension
{
    public function __construct(
        private readonly TagRendererInterface $tagRenderer,
        private readonly EntrypointLookupInterface $entrypointLookup
    ) {
    }

    /**
     * Returns twig functions for registering them in twig environment.
     *
     * There are 5 available twig functions:
     * - encore_entry_js_files
     * - encore_entry_css_files
     * - encore_entry_script_tags
     * - encore_entry_link_tags
     * - encore_entry_exists
     *
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('encore_entry_js_files', [$this->entrypointLookup, 'getJavaScriptFiles']),
            new TwigFunction('encore_entry_css_files', [$this->entrypointLookup, 'getCssFiles']),
            new TwigFunction('encore_entry_script_tags', [$this->tagRenderer, 'renderWebpackScriptTags'], ['is_safe' => ['html']]),
            new TwigFunction('encore_entry_link_tags', [$this->tagRenderer, 'renderWebpackLinkTags'], ['is_safe' => ['html']]),
            new TwigFunction('encore_entry_exists', [$this->entrypointLookup, 'entryExists']),
        ];
    }
}
