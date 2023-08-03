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

namespace Micro\Plugin\Doctrine\Business\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Micro\Plugin\Doctrine\Business\Connection\ConnectionFactoryInterface;
use Micro\Plugin\Doctrine\Business\Metadata\DriverMetadataFactoryInterface;

readonly class EntityManagerFactory implements EntityManagerFactoryInterface
{
    public function __construct(
        private ConnectionFactoryInterface $connectionFactory,
        private DriverMetadataFactoryInterface $driverMetadataFactory
    ) {
    }

    public function create(string $entityManagerName): EntityManagerInterface
    {
        $managerConfig = $this->connectionFactory->create($entityManagerName);
        $driver = $this->driverMetadataFactory->create($entityManagerName);

        return new EntityManager($managerConfig, $driver);
    }
}
