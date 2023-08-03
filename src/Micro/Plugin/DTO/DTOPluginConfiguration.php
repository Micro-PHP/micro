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

namespace Micro\Plugin\DTO;

use Micro\Framework\BootConfiguration\Configuration\PluginConfiguration;

class DTOPluginConfiguration extends PluginConfiguration implements DTOPluginConfigurationInterface
{
    protected const CFG_CLASS_NAMESPACE_GENERAL = 'DTO_CLASS_NAMESPACE_GENERAL';
    protected const CFG_CLASS_SUFFIX = 'DTO_CLASS_SUFFIX';
    protected const CFG_CLASS_SOURCE_PATH = 'DTO_CLASS_SOURCE_PATH';
    protected const CFG_CLASS_SOURCE_FILE_MASK = 'DTO_CLASS_SOURCE_FILE_MASK';
    protected const CFG_GENERATED_PATH_OUTPUT = 'DTO_GENERATED_PATH_OUTPUT';
    protected const CFG_LOGGER_NAME = 'DTO_LOGGER_NAME';

    /**
     * {@inheritDoc}
     */
    public function getNamespaceGeneral(): string
    {
        return $this->configuration->get(self::CFG_CLASS_NAMESPACE_GENERAL, 'App\DTO\Generated');
    }

    /**
     * {@inheritDoc}
     */
    public function getOutputPath(): string
    {
        return $this->configuration->get(self::CFG_GENERATED_PATH_OUTPUT, 'src/Generated');
    }

    /**
     * {@inheritDoc}
     */
    public function getClassSuffix(): string
    {
        return $this->configuration->get(self::CFG_CLASS_SUFFIX, 'Transfer');
    }

    /**
     * {@inheritDoc}
     */
    public function getSchemaPaths(): iterable
    {
        return $this->explodeStringToArray(
            $this->configuration->get(self::CFG_CLASS_SOURCE_PATH, [])
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getSourceFileMask(): string
    {
        return $this->configuration->get(self::CFG_CLASS_SOURCE_FILE_MASK, '*.transfer.xml');
    }

    /**
     * {@inheritDoc}
     */
    public function getLoggerName(): string|null
    {
        return $this->configuration->get(self::CFG_LOGGER_NAME);
    }
}
