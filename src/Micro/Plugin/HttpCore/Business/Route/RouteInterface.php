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

namespace Micro\Plugin\HttpCore\Business\Route;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
interface RouteInterface
{
    public function getUri(): string;

    public function getPattern(): string|null;

    /**
     * @return array<class-string, string|null>|class-string|\Closure|object
     */
    public function getController(): callable|string|array|object;

    /**
     * @return string[]
     */
    public function getMethods(): array;

    public function getName(): string|null;

    /**
     * @return string[]|null
     */
    public function getParameters(): array|null;
}
