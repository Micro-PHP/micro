<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Business\Consumer\Locator;

use Micro\Plugin\Locator\Facade\LocatorFacadeInterface;

readonly class ConsumerLocatorFactory implements ConsumerLocatorFactoryInterface
{
    public function __construct(
        private LocatorFacadeInterface $locatorFacade
    ) {
    }

    public function create(): ConsumerLocatorInterface
    {
        return new ConsumerLocator($this->locatorFacade);
    }
}
