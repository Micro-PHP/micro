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

use Psr\Container\ContainerInterface;

readonly class AutowireHelperFactory implements AutowireHelperFactoryInterface
{
    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function create(): AutowireHelperInterface
    {
        return new AutowireHelper($this->container);
    }
}
