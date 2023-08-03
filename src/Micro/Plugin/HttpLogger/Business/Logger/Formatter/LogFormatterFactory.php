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

namespace Micro\Plugin\HttpLogger\Business\Logger\Formatter;

use Micro\Plugin\HttpLogger\Business\Logger\Formatter\Format\LogFormatterConcreteInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class LogFormatterFactory implements LogFormatterFactoryInterface
{
    /**
     * @param iterable<LogFormatterConcreteInterface> $logFormatterCollection
     */
    public function __construct(
        private iterable $logFormatterCollection,
    ) {
    }

    public function create(string $format): LogFormatterInterface
    {
        return new LogFormatter(
            $this->logFormatterCollection,
            $format
        );
    }
}
