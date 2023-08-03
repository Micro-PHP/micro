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

namespace Micro\Plugin\Filesystem\Facade;

use League\Flysystem\FilesystemOperator;
use Micro\Plugin\Filesystem\Configuration\FilesystemPluginConfigurationInterface;

interface FilesystemFacadeInterface
{
    /**
     * @param string $adapterName
     *
     * @return FilesystemOperator
     */
    public function createFsOperator(string $adapterName = FilesystemPluginConfigurationInterface::ADAPTER_DEFAULT): FilesystemOperator;
}
