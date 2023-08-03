<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Console;

use Micro\Plugin\Amqp\Exception\Consumer\ConsumerException;
use Micro\Plugin\Amqp\Facade\AmqpFacadeInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumeCommand extends Command
{
    protected static $defaultName = 'micro:amqp:consume';
    protected const ARG_CONSUMER = 'consumer';
    protected const HELP = 'This command run consumer. ';

    public function __construct(private readonly AmqpFacadeInterface $amqpFacade)
    {
        parent::__construct(self::$defaultName);
    }

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setHelp(self::HELP);
        $this->addArgument(
            self::ARG_CONSUMER,
            InputArgument::OPTIONAL,
            'Consumer name',
            null);
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $consumerName = $input->getArgument(self::ARG_CONSUMER);
        if (null === $consumerName) {
            $this->loadConsumers($output);

            return Command::SUCCESS;
        }

        $output->writeln(sprintf('Launch of consumer "%s"', $consumerName));
        $consumerClass = $this->amqpFacade->locateConsumer($input->getArgument(self::ARG_CONSUMER));
        $this->amqpFacade->consume($consumerClass);

        $output->writeln(sprintf('Completion of the work of the consumer "%s"', $consumerName));

        return Command::SUCCESS;
    }

    /**
     * @TODO: Temporary solution
     */
    protected function loadConsumers(OutputInterface $output): void
    {
        $started = false;
        foreach ($this->amqpFacade->locateConsumers() as $consumerClass) {
            $started = true;
            $pid = pcntl_fork();
            if (0 === $pid) {
                continue;
            }

            if (-1 === $pid) {
                throw new ConsumerException('Can not starting worker process "%s".');
            }

            $consumerName = $consumerClass::name();
            $output->writeln(sprintf('<info>Starting worker %s. PID: %d</info>', $consumerName, $pid));
            $this->amqpFacade->consume($consumerClass);
        }

        while (-1 != pcntl_waitpid(0, $status)) {
        }

        if (!$started) {
            throw new ConsumerException('There are no consumers were found.');
        }
    }
}
