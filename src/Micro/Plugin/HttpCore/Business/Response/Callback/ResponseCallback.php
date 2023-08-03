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

use Micro\Framework\Autowire\AutowireHelperInterface;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use Micro\Plugin\HttpCore\Exception\RouteInvalidConfigurationException;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class ResponseCallback implements ResponseCallbackInterface
{
    public function __construct(
        private AutowireHelperInterface $autowireHelper,
        private RouteInterface $route
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(): mixed
    {
        $controller = $this->route->getController();
        $routeName = $this->route->getName() ?? $this->route->getUri();

        if (\is_callable($controller)) {
            $callback = $this->autowireHelper->autowire($controller);

            return $callback();
        }

        $classController = $controller;
        $classMethod = $this->route->getName();

        if (\is_string($controller) && (mb_strpos($controller, '::') || class_exists($controller))) {
            $controller = explode('::', $controller);
        }

        if (\is_array($controller)) {
            $controller = array_filter($controller);
            if (!\count($controller)) {
                throw new RouteInvalidConfigurationException($routeName, ['Controller is not defined.']);
            }

            $classController = $controller[0];
            $classMethod = !empty($controller[1]) ? $controller[1] : $this->snakeToCamel($this->route->getName() ?? '');
        }

        /* @psalm-suppress RedundantConditionGivenDocblockType */
        if (!\is_object($classController)) {
            /**
             * @psalm-suppress PossiblyNullArgument
             *
             * @phpstan-ignore-next-line
             */
            $classController = $this->autowireHelper->autowire($classController)();
        }

        $controller = [$classController, $classMethod];

        return \call_user_func($this->autowireHelper->autowire($controller));
    }

    protected function snakeToCamel(string $str): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace(['_', '-'], [' ', ' '], $str))));
    }
}
