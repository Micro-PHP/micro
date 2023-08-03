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

namespace Micro\Plugin\HttpCore\Facade;

use Micro\Plugin\HttpCore\Business\Executor\RouteExecutorInterface;
use Micro\Plugin\HttpCore\Business\Generator\UrlGeneratorInterface;
use Micro\Plugin\HttpCore\Business\Matcher\UrlMatcherInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteBuilderInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
interface HttpFacadeInterface extends UrlMatcherInterface, RouteExecutorInterface, UrlGeneratorInterface
{
    /**
     * @return string[]
     */
    public function getDeclaredRoutesNames(): iterable;

    public function createRouteBuilder(): RouteBuilderInterface;
}
