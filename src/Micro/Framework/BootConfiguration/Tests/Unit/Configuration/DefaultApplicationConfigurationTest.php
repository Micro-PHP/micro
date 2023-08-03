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

namespace Micro\Framework\BootConfiguration\Tests\Unit\Configuration;

use Micro\Framework\BootConfiguration\Configuration\ApplicationConfigurationInterface;
use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Framework\BootConfiguration\Configuration\Exception\InvalidConfigurationException;
use PHPUnit\Framework\TestCase;

class DefaultApplicationConfigurationTest extends TestCase
{
    private ApplicationConfigurationInterface $configuration;

    public const BOOLEAN_VALUES_TRUE = [
        'BOOLEAN_TRUE_STRING' => 'true',
        'BOOLEAN_TRUE_STRING_ON' => 'on',
        'BOOLEAN_TRUE_INT' => 1,
        'BOOLEAN_TRUE_REAL' => true,
    ];

    public const BOOLEAN_VALUES_FALSE = [
        'BOOLEAN_FALSE_STRING' => 'false',
        'BOOLEAN_FALSE_STRING_OFF' => 'off',
        'BOOLEAN_FALSE_INT' => 0,
        'BOOLEAN_FALSE_REAL' => false,
    ];

    public const BOOLEAN_VALUES_DEFAULT_TEST = [
        'BOOLEAN_NULL' => null,
    ];

    public const BOOLEAN_VALUES_INVALID = [
        'BOOLEAN_INVALID' => 'it is invalid value.',
        'VALUE_SHOULD_BE_NON_EMPTY' => null,
    ];

    protected function setUp(): void
    {
        $config = array_merge(
            self::BOOLEAN_VALUES_TRUE,
            self::BOOLEAN_VALUES_FALSE,
            self::BOOLEAN_VALUES_INVALID,
            self::BOOLEAN_VALUES_DEFAULT_TEST,
        );

        $this->configuration = new DefaultApplicationConfiguration($config);
    }

    public function testGetTrue()
    {
        $trueKeys = array_keys(self::BOOLEAN_VALUES_TRUE);
        foreach ($trueKeys as $key) {
            $this->assertTrue($this->configuration->get($key, false, false));
        }
    }

    public function testGetFalse()
    {
        $trueKeys = array_keys(self::BOOLEAN_VALUES_FALSE);
        foreach ($trueKeys as $key) {
            $this->assertFalse($this->configuration->get($key, true, false));
        }
    }

    public function testGetDefaultTrue()
    {
        $keys = array_keys(self::BOOLEAN_VALUES_DEFAULT_TEST);

        foreach ($keys as $key) {
            $this->assertTrue($this->configuration->get($key, true, false));
            $this->assertFalse($this->configuration->get($key, false, false));
        }
    }

    /**
     * @dataProvider dataProviderExceptionalKeys
     */
    public function testExceptional(string $key, mixed $default)
    {
        $this->expectException(InvalidConfigurationException::class);

        var_dump($this->configuration->get($key, $default, false));
    }

    public static function dataProviderExceptionalKeys(): array
    {
        return [
            ['BOOLEAN_INVALID', false],
            ['NO_CONFIGURED', null],
            ['VALUE_SHOULD_BE_NON_EMPTY', null],
        ];
    }
}
