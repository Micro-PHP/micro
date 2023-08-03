<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\KernelApp\Business\Event;

use Micro\Framework\KernelApp\AppKernelInterface;

readonly class ApplicationReadyEvent implements ApplicationReadyEventInterface
{
    public function __construct(private AppKernelInterface $appKernel, private string $environment)
    {
    }

    public function kernel(): AppKernelInterface
    {
        return $this->appKernel;
    }

    public function environment(): string
    {
        return $this->environment;
    }

    public function systemEnvironment(): string
    {
        return \PHP_SAPI;
    }
}
