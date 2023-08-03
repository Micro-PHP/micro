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

namespace Micro\Plugin\Doctrine;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Micro\Plugin\Doctrine\Business\Pool\EntityManagerPoolFactoryInterface;
use Micro\Plugin\Doctrine\Business\Pool\EntityManagerPoolInterface;

class DoctrineFacade implements DoctrineFacadeInterface
{
    private EntityManagerPoolInterface|null $managerPool;

    public function __construct(private readonly EntityManagerPoolFactoryInterface $managerPoolFactory)
    {
        $this->managerPool = null;
    }

    public function getManager(string $name = null): EntityManagerInterface
    {
        if (!$name) {
            $name = DoctrinePluginConfigurationInterface::MANAGER_DEFAULT;
        }

        return $this->managerPool()->getManager($name);
    }

    /**
     * @throws MissingMappingDriverImplementation
     * @throws Exception
     */
    public function getDefaultManager(): EntityManagerInterface
    {
        return $this->getManager();
    }

    protected function managerPool(): EntityManagerPoolInterface
    {
        if (null === $this->managerPool) {
            $this->managerPool = $this->managerPoolFactory->create();
        }

        return $this->managerPool;
    }
}
