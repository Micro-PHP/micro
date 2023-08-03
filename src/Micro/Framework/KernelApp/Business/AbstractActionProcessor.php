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

use Micro\Framework\KernelApp\AppKernelInterface;

abstract class AbstractActionProcessor implements KernelActionProcessorInterface
{
    public function process(AppKernelInterface $appKernel): void
    {
        foreach ($this->createActionProcessorCollection() as $actionProcessor) {
            $actionProcessor->process($appKernel);
        }
    }

    /**
     * @return KernelActionProcessorInterface[]
     */
    abstract protected function createActionProcessorCollection(): array;
}
