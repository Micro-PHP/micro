<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Console\Business\Factory;

use Micro\Framework\Autowire\AutowireHelperInterface;
use Micro\Plugin\Locator\Facade\LocatorFacadeInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

readonly class ConsoleApplicationFactory implements ConsoleApplicationFactoryInterface
{
    public function __construct(
        private LocatorFacadeInterface $locatorFacade,
        private AutowireHelperInterface $autowireHelper
    ) {
    }

    public function create(): Application
    {
        $application = new Application();
        $application->setAutoExit(false);
        // $application->setCatchExceptions(true);
        $this->registerCommands($application);

        return $application;
    }

    protected function registerCommands(Application $application): void
    {
        foreach ($this->locatorFacade->lookup(Command::class) as $command) {
            $cmdCallback = $this->autowireHelper->autowire($command);
            $application->add($cmdCallback());
        }
    }
}
