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

use Micro\Plugin\HttpCore\Exception\RouteInvalidConfigurationException;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
interface RouteBuilderInterface
{
    /**
     * @return $this
     */
    public function setName(string $name): self;

    /**
     * Add HTTP Method (GET,POST,PUT,PATCH,DELETE).
     *
     * @return $this
     */
    public function addMethod(string $method): self;

    /**
     * Set http Methods (GET,POST,PUT,PATCH,DELETE).
     *
     * @param string[] $methods
     *
     * @return $this
     */
    public function setMethods(array $methods): self;

    /**
     * @param array<class-string, string|null>|class-string|\Closure $action
     *
     * @return $this
     */
    public function setController(string|array|\Closure $action): self;

    /**
     * @return $this
     */
    public function setUri(string $uri): self;

    /**
     * @throws RouteInvalidConfigurationException
     */
    public function build(): RouteInterface;
}
