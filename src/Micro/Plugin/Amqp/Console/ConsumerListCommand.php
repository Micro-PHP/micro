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

use Micro\Plugin\Amqp\Facade\AmqpFacadeInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumerListCommand extends Command
{
    protected static $defaultName = 'micro:amqp:consumer:list';
    protected const HELP = 'This command show all registered consumers with settings.';

    public function __construct(
        private readonly AmqpFacadeInterface $amqpFacade
    ) {
        parent::__construct(self::$defaultName);
    }

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setHelp(self::HELP);
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = new Table($output);
        $table->setHeaders([
            'Consumer', 'Channel', 'Queue', 'Connection', 'Tag', 'Class',
        ]);

        foreach ($this->amqpFacade->locateConsumers() as $consumerClass) {
            $consumerName = $consumerClass::name();
            $config = $this->amqpFacade->getConsumerConfiguration($consumerClass::name());
            $table->addRow([
                $consumerName,
                $config->getChannel(),
                $config->getQueue(),
                $config->getConnection(),
                $config->getTag(),
                $consumerClass,
            ]);
        }

        $table->render();

        return Command::SUCCESS;
    }
}
