<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Locator\Facade;

use Micro\Plugin\Locator\Locator\LocatorFactoryInterface;

readonly class LocatorFacade implements LocatorFacadeInterface
{
    public function __construct(
        private LocatorFactoryInterface $locatorFactory
    ) {
    }

    public function lookup(string $classOrInterfaceName): iterable
    {
        return $this->locatorFactory
            ->create()
            ->lookup($classOrInterfaceName);
    }
}
