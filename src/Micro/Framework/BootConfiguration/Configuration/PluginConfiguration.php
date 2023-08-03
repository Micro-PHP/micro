<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\BootConfiguration\Configuration;

class PluginConfiguration implements PluginConfigurationInterface
{
    public function __construct(
        protected readonly ApplicationConfigurationInterface $configuration
    ) {
    }

    /**
     * @param string|string[] $list
     *
     * @return string[]
     */
    protected function explodeStringToArray(string|array $list, string $separator = ','): array
    {
        if (\is_array($list)) {
            return $list;
        }

        if ('' === $separator) {
            return [$list];
        }

        $itemsColl = explode($separator, $list);

        return array_map('trim', $itemsColl);
    }
}
