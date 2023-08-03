<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\BootConfiguration\Configuration;

use Micro\Framework\BootConfiguration\Configuration\Exception\InvalidConfigurationException;

class DefaultApplicationConfiguration implements ApplicationConfigurationInterface
{
    private const BOOLEAN_TRUE = [
        'true', 'on', '1', 'yes',
    ];

    private const BOOLEAN_FALSE = [
        'false', 'off', '0', 'no',
    ];

    /**
     * @param array<string, mixed> $configuration
     */
    public function __construct(private readonly array $configuration)
    {
    }

    public function get(string $key, mixed $default = null, bool $nullable = true): mixed
    {
        if (\is_bool($default)) {
            try {
                return $this->getBooleanValue($key, $default);
            } catch (\InvalidArgumentException $exception) {
                throw new InvalidConfigurationException(sprintf('Configuration key "%s" can not be converted to boolean', $key), 0, $exception);
            }
        }

        $value = $this->getValue($key, $default);

        if (false === $nullable && !$value && !is_numeric($value)) {
            throw new InvalidConfigurationException(sprintf('Configuration key "%s" can not be NULL', $key));
        }

        return $value;
    }

    protected function getBooleanValue(string $key, bool $default): bool
    {
        $value = $this->getValue($key, $default);
        if (\is_bool($value)) {
            return $value;
        }

        if (null === $value) {
            return $default;
        }

        $value = mb_strtolower($value);

        if (\in_array($value, self::BOOLEAN_TRUE, true)) {
            return true;
        }

        if (\in_array($value, self::BOOLEAN_FALSE, true)) {
            return false;
        }

        throw new \InvalidArgumentException('Value can not be converted to boolean.');
    }

    protected function getValue(string $key, mixed $default): mixed
    {
        return $this->configuration[$key] ?? $default;
    }
}
