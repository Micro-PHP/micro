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

namespace Micro\Plugin\HttpMiddleware\Plugin;

trait MiddlewareAllowAllTrait
{
    /**
     * @return string[]
     */
    public function getRequestMatchMethods(): array
    {
        return ['get', 'post', 'patch', 'put', 'delete'];
    }

    public function getRequestMatchPath(): string
    {
        return '^/';
    }

    public function getMiddlewarePriority(): int
    {
        return 0;
    }
}
