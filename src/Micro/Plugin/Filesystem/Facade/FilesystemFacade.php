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

class FilesystemFacade implements FilesystemFacadeInterface
{
    /**
     * {@inheritDoc}
     */
    public function createFsOperator(string $adapterName = FilesystemPluginConfigurationInterface::ADAPTER_DEFAULT): FilesystemOperator
    {
        $message = <<<EOF
            The `%s` adapter cannot be initialized.
            Please check if you have made a mistake in the naming or if you have not installed it.
        EOF;

        throw new \Exception(sprintf($message, $adapterName));
    }
}
