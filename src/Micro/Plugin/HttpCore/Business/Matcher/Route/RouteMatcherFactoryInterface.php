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

namespace Micro\Plugin\HttpCore\Business\Matcher\Route;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
interface RouteMatcherFactoryInterface
{
    public function create(): RouteMatcherInterface;
}
