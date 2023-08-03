<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Console\Facade;

use Micro\Plugin\Console\Business\Factory\ConsoleApplicationFactoryInterface;

readonly class ConsoleApplicationFacade implements ConsoleApplicationFacadeInterface
{
    public function __construct(
        private ConsoleApplicationFactoryInterface $consoleApplicationFactory
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function run(): int
    {
        return $this->consoleApplicationFactory
            ->create()
            ->run();
    }
}
