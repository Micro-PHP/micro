<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\LoggerMonolog\Business\Handler\Type\Stream;

use Micro\Plugin\LoggerMonolog\Business\Handler\Type\AbstractHandler;
use Micro\Plugin\LoggerMonolog\Configuration\Handler\Type\HandlerStreamConfigurationInterface;
use Monolog\Handler\StreamHandler as MonologStreamHandler;
use Monolog\LogRecord;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 *
 * @codeCoverageIgnore
 */
class StreamHandler extends AbstractHandler
{
    /** @psalm-suppress PropertyNotSetInConstructor */
    private MonologStreamHandler $handler;

    public function configure(): void
    {
        /** @var HandlerStreamConfigurationInterface $configuration */
        $configuration = $this->handlerConfiguration;

        $this->handler = new MonologStreamHandler(
            $configuration->getLogFile(),
            // @phpstan-ignore-next-line
            $this->loggerProviderTypeConfiguration
                ->getLogLevel()
                ->level(),
            true,
            null,
            $configuration->useLocking(),
        );
    }

    protected function write(LogRecord $record): void
    {
        $this->handler->write($record);
    }
}
