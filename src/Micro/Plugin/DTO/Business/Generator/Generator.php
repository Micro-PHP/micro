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

namespace Micro\Plugin\DTO\Business\Generator;

use Micro\Library\DTO\GeneratorFacadeInterface;

readonly class Generator implements GeneratorInterface
{
    /**
     * @param GeneratorFacadeInterface $generatorFacade
     */
    public function __construct(private GeneratorFacadeInterface $generatorFacade)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function generate(): void
    {
        $this->generatorFacade->generate();
    }
}
