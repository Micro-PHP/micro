<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Twig;

interface TwigPluginConfigurationInterface
{
    public const IS_DEBUG_DEFAULT = false;
    public const CHARSET_DEFAULT = 'utf-8';
    public const CACHE_DEFAULT = null;
    public const IS_AUTO_RELOAD_DEFAULT = false;
    public const IS_STRICT_VARIABLES_DEFAULT = false;
    public const OPTIMIZATIONS_DEFAULT = -1;

    /**
     * @return array<string,  bool|int|string>
     */
    public function getConfigurationArray(): array;

    /**
     * When set to true, the generated templates have a __toString() method that you can use to display the generated nodes (default to false).
     */
    public function isDebug(): bool;

    /**
     * The charset used by the templates.
     */
    public function getCharset(): string;

    /**
     * An absolute path where to store the compiled templates, or null to disable caching (which is the default).
     */
    public function getCachePath(): ?string;

    /**
     * When developing with Twig, it's useful to recompile the template whenever the source code changes.
     * If you don't provide a value for the auto_reload option, it will be determined automatically based on the debug value.
     */
    public function isAutoReload(): bool;

    /**
     * If set to false, Twig will silently ignore invalid variables
     *      (variables and or attributes/methods that do not exist) and replace them with a null value.
     *
     * When set to true, Twig throws an exception instead (default to false).
     */
    public function isStrictVariables(): bool;

    /**
     * Sets the default auto-escaping strategy (name, html, js, css, url, html_attr, or a PHP callback that takes the template "filename"
     *      and returns the escaping strategy to use -- the callback cannot be a function name to avoid collision with built-in escaping strategies);
     *      set it to false to disable auto-escaping.
     *
     * The name escaping strategy determines the escaping strategy to use for a template based on the template filename extension
     *      (this strategy does not incur any overhead at runtime as auto-escaping is done at compilation time.)
     *
     * @return string
     */
    //    public function getAutoescape(): string;

    /**
     * A flag that indicates which optimizations to apply (default to -1 -- all optimizations are enabled; set it to 0 to disable).
     */
    public function getOptimizations(): int;
}
