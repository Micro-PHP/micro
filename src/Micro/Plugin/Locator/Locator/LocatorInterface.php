<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Locator\Locator;

interface LocatorInterface
{
    /**
     * @template T of Object
     *
     * @param class-string<T> $classOrInterfaceName
     *
     * @return class-string<T>[]
     */
    public function lookup(string $classOrInterfaceName): iterable;
}
