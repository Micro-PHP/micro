<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\ConfigurationHelper\Business\Path;

class PathResolverCacheDecorator implements PathResolverInterface
{
    /**
     * @var array<string, string>
     */
    private array $cache;

    public function __construct(
        private readonly PathResolverInterface $pathResolver
    ) {
        $this->cache = [];
    }

    public function resolve(string $relative): string
    {
        if (!\array_key_exists($relative, $this->cache)) {
            $this->cache[$relative] = $this->pathResolver->resolve($relative);
        }

        return $this->cache[$relative];
    }
}
