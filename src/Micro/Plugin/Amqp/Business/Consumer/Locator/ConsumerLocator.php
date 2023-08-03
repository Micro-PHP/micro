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

namespace Micro\Plugin\Amqp\Business\Consumer\Locator;

use Micro\Plugin\Amqp\Business\Consumer\Processor\ConsumerProcessorInterface;
use Micro\Plugin\Amqp\Exception\Consumer\ConsumerNotRegisteredException;
use Micro\Plugin\Locator\Facade\LocatorFacadeInterface;

readonly class ConsumerLocator implements ConsumerLocatorInterface
{
    public function __construct(
        private LocatorFacadeInterface $locatorFacade
    ) {
    }

    public function locateConsumers(): iterable
    {
        $it = $this->locatorFacade->lookup(ConsumerProcessorInterface::class);

        /** @var class-string<ConsumerProcessorInterface> $className */
        foreach ($it as $className) {
            yield $className;
        }
    }

    public function locateConsumer(string $consumerName): string
    {
        foreach ($this->locateConsumers() as $consumerClass) {
            if ($consumerClass::name() === $consumerName) {
                return $consumerClass;
            }
        }

        throw new ConsumerNotRegisteredException($consumerName);
    }
}
