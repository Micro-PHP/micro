<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\KernelApp\Business;

use Micro\Framework\KernelApp\Business\Processor\AppCreateEventTerminate;

class KernelTerminateActionProcessor extends AbstractActionProcessor
{
    /**
     * {@inheritDoc}
     */
    protected function createActionProcessorCollection(): array
    {
        return [
            new AppCreateEventTerminate(),
        ];
    }
}
