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

use Doctrine\ORM\EntityManagerInterface;
use Micro\Plugin\Doctrine\Business\EntityManager\EntityManagerFactoryInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class EntityManagerPool implements EntityManagerPoolInterface
{
    /**
     * @param array<string, EntityManagerInterface> $entityManagerPool
     */
    public function __construct(
        private readonly EntityManagerFactoryInterface $entityManagerFactory,
        private array $entityManagerPool = []
    ) {
    }

    public function getManager(string $name): EntityManagerInterface
    {
        if (!\array_key_exists($name, $this->entityManagerPool)) {
            $this->entityManagerPool[$name] = $this->entityManagerFactory->create($name);
        }

        return $this->entityManagerPool[$name];
    }

    public function getDefaultManager(): EntityManagerInterface
    {
        throw new \LogicException('Method is not supported.');
    }
}
