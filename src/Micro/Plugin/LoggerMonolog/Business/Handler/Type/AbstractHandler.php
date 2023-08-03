<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\LoggerMonolog\Business\Handler\Type;

use Micro\Framework\DependencyInjection\Container;
use Micro\Plugin\Logger\Configuration\LoggerProviderTypeConfigurationInterface;
use Micro\Plugin\LoggerMonolog\Business\Handler\HandlerInterface;
use Micro\Plugin\LoggerMonolog\Configuration\Handler\HandlerConfigurationInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 *
 * @codeCoverageIgnore
 */
abstract class AbstractHandler extends AbstractProcessingHandler implements HandlerInterface
{
    public function __construct(
        protected readonly Container $container,
        protected readonly HandlerConfigurationInterface $handlerConfiguration,
        protected readonly LoggerProviderTypeConfigurationInterface $loggerProviderTypeConfiguration
    ) {
        $levelName = mb_strtoupper($loggerProviderTypeConfiguration->getLogLevel()->level());

        if (!\in_array($levelName, Level::NAMES, true)) {
            throw new \RuntimeException(sprintf('Invalid log level `%s` for the logger name `%s`.', $levelName, $this->loggerProviderTypeConfiguration->getLoggerName()));
        }

        $monoLevel = Level::fromName($levelName);

        parent::__construct($monoLevel);

        $this->configure();
    }

    public function configure(): void
    {
    }
}
