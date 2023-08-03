<?php

declare(strict_types=1);

/*
 * This file is part of the WebpackEncore plugin for Micro Framework.
 * (c) Oleksii Bulba <oleksii.bulba@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Micro\Plugin\WebpackEncore\Asset;

use Micro\Plugin\WebpackEncore\Exception\EntrypointNotFoundException;

interface EntrypointLookupInterface
{
    /**
     * Twig function to get all JavaScript files for an entry.
     *
     * encore_entry_js_files(string $entryName): array
     *
     * Usage: {{ encore_entry_js_files('app') }}
     *
     * @throws EntrypointNotFoundException if an entry name is passed that does not exist in entrypoints.json
     *
     * @psalm-return array<string>
     */
    public function getJavaScriptFiles(string $entryName): array;

    /**
     * Twig function to get all CSS files for an entry.
     *
     * encore_entry_css_files(string $entryName): array
     *
     * Usage: {{ encore_entry_css_files('app') }}
     *
     * @throws EntrypointNotFoundException if an entry name is passed that does not exist in entrypoints.json
     *
     * @psalm-return array<string>
     */
    public function getCssFiles(string $entryName): array;

    /**
     * Twig function to check if an entry exists.
     *
     * encore_entry_exists(string $entryName): bool
     *
     * Usage: {% if encore_entry_exists('app') %}
     */
    public function entryExists(string $entryName): bool;
}
