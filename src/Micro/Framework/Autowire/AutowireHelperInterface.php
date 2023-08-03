<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\Autowire;

interface AutowireHelperInterface
{
    /**
     * @param class-string|array<class-string|string>|array<object|string>|callable $target
     */
    public function autowire(string|array|callable $target): callable;
}
