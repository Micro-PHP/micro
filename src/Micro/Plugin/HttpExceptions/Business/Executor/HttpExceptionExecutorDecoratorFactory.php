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

namespace Micro\Plugin\HttpExceptions\Business\Executor;

use \Micro\Plugin\HttpCore\Business\Executor\RouteExecutorFactoryInterface;
use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorInterface;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class HttpExceptionExecutorDecoratorFactory implements RouteExecutorFactoryInterface
{
    public function __construct(
        private RouteExecutorInterface $decorated
    ) {
    }

    public function create(): RouteExecutorInterface
    {
        return new HttpExceptionExecutorDecorator($this->decorated);
    }
}
