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

namespace Micro\Plugin\Doctrine\Business\Pool;

use Micro\Plugin\Doctrine\Business\EntityManager\EntityManagerFactoryInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class EntityManagerPoolFactory implements EntityManagerPoolFactoryInterface
{
    public function __construct(private EntityManagerFactoryInterface $entityManagerFactory)
    {
    }

    public function create(): EntityManagerPoolInterface
    {
        return new EntityManagerPool($this->entityManagerFactory);
    }
}
