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

namespace Micro\Plugin\Cache\Communication\Cli;

use Micro\Plugin\Cache\Facade\CacheFacadeInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ClearCacheCommand extends Command
{
    public function __construct(
        private readonly CacheFacadeInterface $cacheFacade
    ) {
        parent::__construct('cache:clear');
    }

    public function configure(): void
    {
        $this
            ->addArgument('pools', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'A list of cache pools or cache pool clearer\'s')
            ->setHelp(
                <<<'EOF'
The <info>%command.name%</info> command clears the given cache pools or cache pool clearer\'s.

    %command.full_name% <cache pool or clearer 1> [...<cache pool or clearer N>]
EOF
            )
            ->setDescription('Clear cache pools');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($input->getArgument('pools') as $poolName) {
            $io->comment(sprintf('Clearing cache pool: <info>%s</info>', $poolName));
            $pool = $this->cacheFacade->getCachePsr6($poolName);
            $pool->clear();
        }

        $io->success('Cache was successfully cleared.');

        return self::SUCCESS;
    }
}
