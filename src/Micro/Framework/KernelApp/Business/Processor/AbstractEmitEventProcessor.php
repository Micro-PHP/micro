<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\KernelApp\Business\Processor;

use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\EventEmitter\EventInterface;
use Micro\Framework\KernelApp\AppKernelInterface;
use Micro\Framework\KernelApp\Business\KernelActionProcessorInterface;
use Micro\Plugin\EventEmitter\EventsFacadeInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class AbstractEmitEventProcessor implements KernelActionProcessorInterface
{
    public function process(AppKernelInterface $appKernel): void
    {
        $event = $this->createEvent($appKernel);

        $this->lookupEventEmitter($appKernel->container())->emit($event);
    }

    abstract protected function createEvent(AppKernelInterface $appKernel): EventInterface;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     *
     * @psalm-suppress MoreSpecificReturnType
     */
    protected function lookupEventEmitter(Container $container): EventsFacadeInterface
    {
        /**
         * @psalm-suppress LessSpecificReturnStatement
         *
         * @phpstan-ignore-next-line
         */
        return $container->get(EventsFacadeInterface::class);
    }
}
