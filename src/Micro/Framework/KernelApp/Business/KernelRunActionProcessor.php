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

use Micro\Framework\KernelApp\Business\Processor\AppCreateEventRunSuccess;
use Micro\Framework\KernelApp\Business\Processor\ProvideKernelProcessor;

class KernelRunActionProcessor extends AbstractActionProcessor
{
    /**
     * {@inheritDoc}
     */
    protected function createActionProcessorCollection(): array
    {
        return [
            $this->createProvideKernelProcessor(),
            $this->createAppCreateEventRunSuccess(),
        ];
    }

    protected function createAppCreateEventRunSuccess(): KernelActionProcessorInterface
    {
        return new AppCreateEventRunSuccess();
    }

    protected function createProvideKernelProcessor(): KernelActionProcessorInterface
    {
        return new ProvideKernelProcessor();
    }
}
