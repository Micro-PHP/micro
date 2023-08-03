<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\BootDependency\Plugin;

use Micro\Framework\DependencyInjection\Container;

interface DependencyProviderInterface
{
    public function provideDependencies(Container $container): void;
}
