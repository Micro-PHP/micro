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

namespace Micro\Plugin\Doctrine\Configuration\Driver;

use Micro\Framework\BootConfiguration\Configuration\PluginRoutingKeyConfiguration;

class PdoSqliteDriverConfiguration extends PluginRoutingKeyConfiguration implements DriverConfigurationInterface
{
    use UserPasswordTrait;

    public const CFG_PATH = 'ORM_%s_PATH';
    public const CFG_IN_MEMORY = 'ORM_%s_IN_MEMORY';

    public function getPath(): ?string
    {
        return $this->get(self::CFG_PATH, null, false);
    }

    /**
     * True if the SQLite database should be in-memory (non-persistent). Mutually exclusive with path. path takes precedence.
     */
    public function inMemory(): bool
    {
        return $this->get(self::CFG_IN_MEMORY, false);
    }

    public function getParameters(): array
    {
        $memP = [
            'memory' => true,
        ];

        $isInMemory = $this->inMemory();
        if (!$isInMemory) {
            $memP['memory'] = false;
            $memP['path'] = $this->getPath();
        }

        return [
            'driver' => static::name(),
            'user' => $this->getUser(),
            'password' => $this->getPassword(),
            ...$memP,
        ];
    }

    public static function name(): string
    {
        return 'pdo_sqlite';
    }
}
