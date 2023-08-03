<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Twig\Business\Environment;

use Twig\Environment;
use Twig\Error\Error;

interface EnvironmentFactoryInterface
{
    /**
     * @throws Error
     */
    public function create(): Environment;
}
