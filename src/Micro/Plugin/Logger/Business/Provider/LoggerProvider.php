<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Logger\Business\Provider;

use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\Logger\Configuration\LoggerPluginConfigurationInterface;
use Micro\Plugin\Logger\Configuration\LoggerProviderTypeConfigurationInterface;
use Micro\Plugin\Logger\Exception\LoggerAdapterAlreadyExistsException;
use Micro\Plugin\Logger\Exception\LoggerAdapterNameInvalidException;
use Micro\Plugin\Logger\Exception\LoggerAdapterNotRegisteredException;
use Micro\Plugin\Logger\Plugin\LoggerProviderPluginInterface;
use Psr\Log\LoggerInterface;

class LoggerProvider implements LoggerProviderInterface
{
    /**
     * @var array<string, LoggerInterface>
     */
    private array $loggerCollection;
    /**
     * @var array<string, LoggerProviderPluginInterface>
     */
    private array $loggerAdapters;

    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly LoggerPluginConfigurationInterface $loggerPluginConfiguration
    ) {
        $this->loggerCollection = [];
        $this->loggerAdapters = [];
    }

    /**
     * {@inheritDoc}
     */
    public function getLogger(string $loggerName): LoggerInterface
    {
        if (\array_key_exists($loggerName, $this->loggerCollection)) {
            return $this->loggerCollection[$loggerName];
        }

        $loggerProviderTypeConfig = $this->loggerPluginConfiguration->getLoggerProviderTypeConfig($loggerName);
        $this->lookupLoggerAdapters();
        $logger = $this->createLogger($loggerProviderTypeConfig);

        $this->loggerCollection[$loggerName] = $logger;

        return $logger;
    }

    protected function createLogger(
        LoggerProviderTypeConfigurationInterface $loggerProviderTypeConfig,
    ): LoggerInterface {
        $loggerAdapterRegistered = array_keys($this->loggerAdapters);

        if (1 === \count($loggerAdapterRegistered)) {
            return $this->loggerAdapters[array_pop($loggerAdapterRegistered)]
                ->getLoggerFactory()
                ->create($loggerProviderTypeConfig);
        }

        $adapterType = mb_strtolower($loggerProviderTypeConfig->getType());

        foreach ($this->loggerAdapters as $providerName => $loggerAdapter) {
            if (mb_strtolower($providerName) === $adapterType) {
                return $loggerAdapter
                    ->getLoggerFactory()
                    ->create($loggerProviderTypeConfig);
            }
        }

        $loggerAdapterRegisteredImploded = implode(', ', $loggerAdapterRegistered);

        throw new LoggerAdapterNotRegisteredException(<<<EOF
                Logger adapter `$adapterType` is not registered. You may have forgotten to install a required plugin.
                Installed adapters: $loggerAdapterRegisteredImploded
                EOF);
    }

    protected function lookupLoggerAdapters(): void
    {
        if ($this->loggerAdapters) {
            return;
        }

        $iterator = $this->kernel->plugins(LoggerProviderPluginInterface::class);
        $installed = false;
        /** @var LoggerProviderPluginInterface $adapter */
        foreach ($iterator as $adapter) {
            $adapterName = trim($adapter->getLoggerAdapterName());
            if (!$adapterName) {
                throw new LoggerAdapterNameInvalidException(sprintf('Logger adapter `%s::getLoggerAdapterName()` is empty.', \get_class($adapter)));
            }

            if (\array_key_exists($adapterName, $this->loggerAdapters)) {
                throw new LoggerAdapterAlreadyExistsException(sprintf('Logger adapter with alias `%s` already exists.', $adapterName));
            }

            $this->loggerAdapters[$adapterName] = $adapter;
            $installed = true;
        }

        if ($installed) {
            return;
        }

        throw new LoggerAdapterNotRegisteredException(<<<EOF
                There are no logger adapters available.
                You should install one of the logger adapter plugin.
                We recommend using the package `micro/plugin-logger-monolog`.
                EOF);
    }
}
