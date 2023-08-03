<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\LoggerMonolog\Configuration\Handler;

use Micro\Plugin\LoggerMonolog\Configuration\Logger\MonologPluginConfigurationInterface;

readonly class HandlerConfigurationFactory implements HandlerConfigurationFactoryInterface
{
    /**
     * @template T of HandlerConfigurationInterface
     *
     * @psalm-param iterable<class-string<T>> $handlerConfigurationClassCollection
     */
    public function __construct(
        private MonologPluginConfigurationInterface $pluginConfiguration,
        private iterable $handlerConfigurationClassCollection
    ) {
    }

    public function create(string $handlerName): HandlerConfigurationInterface
    {
        $handlerType = $this->pluginConfiguration->getHandlerType($handlerName);

        foreach ($this->handlerConfigurationClassCollection as $handlerConfigurationClass) {
            if (!\in_array(HandlerConfigurationInterface::class, class_implements($handlerConfigurationClass), true)) {
                $this->throwHandlerCreateException($handlerName, sprintf('Class "%s" should be implements "%s".',
                    $handlerConfigurationClass, HandlerConfigurationInterface::class
                ));
            }

            if ($handlerConfigurationClass::type() !== $handlerType) {
                continue;
            }

            return new $handlerConfigurationClass($this->pluginConfiguration->applicationConfiguration(), $handlerName);
        }

        throw new \RuntimeException(sprintf('Can not resolve configuration class for handler "%s"', $handlerName));
    }

    protected function throwHandlerCreateException(string $handlerName, string $message): void
    {
        throw new \RuntimeException(sprintf('Logger handler "%s" create error: %s', $handlerName, $message));
    }
}
