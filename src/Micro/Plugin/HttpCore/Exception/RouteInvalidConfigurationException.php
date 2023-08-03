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

namespace Micro\Plugin\HttpCore\Exception;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class RouteInvalidConfigurationException extends RouteConfigurationException
{
    /**
     * @var string[]
     */
    private array $messages;

    /**
     * @param string[] $messages
     */
    public function __construct(string $routeName, array $messages, int $code = 0, ?\Throwable $previous = null)
    {
        $message = <<<EOF
            Invalid route "%s" configuration:
                * %s
        EOF;

        $message = sprintf($message, $routeName, implode("\r\n        * ", $messages));

        $this->messages = $messages;
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }

    /**
     * @return string[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
