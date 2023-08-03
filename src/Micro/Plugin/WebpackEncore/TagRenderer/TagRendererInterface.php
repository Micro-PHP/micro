<?php

declare(strict_types=1);

/*
 * This file is part of the WebpackEncore plugin for Micro Framework.
 * (c) Oleksii Bulba <oleksii.bulba@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Micro\Plugin\WebpackEncore\TagRenderer;

interface TagRendererInterface
{
    /**
     * Twig function to render script tags for an entry.
     *
     * encore_entry_script_tags(string $entryName, string $packageName = null): string
     *
     * Usage: {{ encore_entry_script_tags('app') }}
     */
    public function renderWebpackScriptTags(string $entryName, array $extraAttributes = []): string;

    /**
     * Twig function to render link tags for an entry.
     *
     * encore_entry_link_tags(string $entryName, string $packageName = null): string
     *
     * Usage: {{ encore_entry_link_tags('app') }}
     */
    public function renderWebpackLinkTags(string $entryName, array $extraAttributes = []): string;
}
