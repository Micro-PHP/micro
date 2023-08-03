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

namespace Micro\Plugin\HttpCore\Business\Generator;

use Micro\Plugin\HttpCore\Exception\RouteNotFoundException;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
interface UrlGeneratorInterface
{
    /**
     * @param array<string, mixed>|null $parameters
     *
     * @throws RouteNotFoundException
     * @throws \RuntimeException
     */
    public function generateUrlByRouteName(string $routeName, array|null $parameters = []): string;
}
