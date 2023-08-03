<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\ConfigurationHelper\Facade;

use Micro\Plugin\ConfigurationHelper\Business\Path\PathResolverInterface;

readonly class ConfigurationHelperFacade implements ConfigurationHelperFacadeInterface
{
    public function __construct(
        private PathResolverInterface $pathResolver
    ) {
    }

    public function resolvePath(string $relativePath): string
    {
        return $this->pathResolver->resolve($relativePath);
    }
}
