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

namespace Micro\Plugin\HttpCore\Business\Response\Callback;

use Micro\Framework\Autowire\AutowireHelperFactoryInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class ResponseCallbackFactory implements ResponseCallbackFactoryInterface
{
    public function __construct(
        private AutowireHelperFactoryInterface $autowireHelperFactory
    ) {
    }

    public function create(RouteInterface $route): ResponseCallbackInterface
    {
        return new ResponseCallback(
            $this->autowireHelperFactory->create(),
            $route,
        );
    }
}
