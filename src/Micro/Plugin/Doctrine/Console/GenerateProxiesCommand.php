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

namespace Micro\Plugin\Doctrine\Console;

use Doctrine\ORM\Tools\Console\Command as ORM;
use Micro\Plugin\Doctrine\DoctrineFacadeInterface;

class GenerateProxiesCommand extends ORM\GenerateProxiesCommand
{
    public function __construct(DoctrineFacadeInterface $doctrineFacade)
    {
        parent::__construct($doctrineFacade);
    }
}
