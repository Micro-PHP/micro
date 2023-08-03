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

namespace Micro\Plugin\DTO\Console;

use Micro\Plugin\DTO\Facade\DTOFacadeInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateDTOCommand extends Command
{
    protected const HELP = 'Generate DTO classes.';
    protected static $defaultName = 'micro:dto:generate';

    public function __construct(
        private readonly DTOFacadeInterface $DTOFacade
    ) {
        parent::__construct(self::$defaultName);
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info> Generate DTO classes... </info>');
        try {
            $this->DTOFacade->generate();
            $output->writeln('<info> Success!</info>');
        } catch (\Throwable $e) {
            $output->writeln(sprintf('<error> %s </error>', $e->getMessage()));

            throw $e;
        }

        return Command::SUCCESS;
    }
}
