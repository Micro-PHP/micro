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

namespace Micro\Plugin\Doctrine\Business\Locator;

use Micro\Framework\Kernel\KernelInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class EntityFileConfigurationLocatorFactory implements EntityFileConfigurationLocatorFactoryInterface
{
    public function __construct(private KernelInterface $kernel)
    {
    }

    public function create(): EntityFileConfigurationLocatorInterface
    {
        return new AttributeEntityFileConfigurationLocator($this->kernel);
    }
}
