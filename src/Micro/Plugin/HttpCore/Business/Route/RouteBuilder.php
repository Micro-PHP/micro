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
class RouteBuilder implements RouteBuilderInterface
{
    private string|null $name;

    /**
     * @var array<class-string, string|null>|class-string|\Closure|null
     */
    private mixed $action;

    private string|null $uri;

    /**
     * @var array|string[]
     */
    private array $methods;

    /**
     * @param string[] $methodsByDefault
     */
    public function __construct(
        private readonly array $methodsByDefault = [
            'PUT', 'POST', 'PATCH', 'GET', 'DELETE',
        ],
    ) {
        $this->name = null;
        $this->action = null;
        $this->uri = null;
        $this->methods = $this->methodsByDefault;
    }

    /**
     * {@inheritDoc}
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addMethod(string $method): self
    {
        if (!\in_array($method, $this->methods)) {
            $this->methods[] = mb_strtoupper($method);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setMethods(array $methods): self
    {
        $this->methods = [];

        foreach ($methods as $method) {
            $this->addMethod($method);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setController(string|array|\Closure $action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * TODO: Move pattern builder to separate class.
     *
     * {@inheritDoc}
     */
    public function build(): RouteInterface
    {
        $exceptions = [];

        if (!$this->uri) {
            $this->uri = '';

            $exceptions[] = 'Uri can not be empty.';
        }

        if ($this->name && !preg_match('/^(.[aA-zZ_])/', $this->name)) {
            $exceptions[] = 'The route name must match "aA-zZ0-9_".';
        }

        if (!$this->action) {
            $exceptions[] = 'The route action can not be empty and should be callable.';
        }

        if (
            $this->action &&
            (
                !\is_callable($this->action) &&
                (\is_string($this->action) && (class_exists($this->action) && !$this->name))
            )
        ) {
            $exceptions[] = 'The route action should be callable. Examples: `[object, "method|<route_name>"], [Classname, "metnod|<routeName>"], Classname::method, Classname, function() {}` Current value: '.$this->action;
        }

        if (!\count($this->methods)) {
            $exceptions[] = 'The route should be contain one or more methods from %s::class.';
        }

        if (\count($exceptions)) {
            $exception = new RouteInvalidConfigurationException($this->name ?: $this->uri ?: 'Undefined', $exceptions);

            $this->clear();

            throw $exception;
        }

        $pattern = null;
        $parameters = null;
        /** @psalm-suppress PossiblyNullArgument */
        $isDynamic = preg_match_all('/\{\s*([^}\s]*)\s*}/', $this->uri, $matches);
        if ($isDynamic) {
            $parameters = $matches[1];
            /** @psalm-suppress PossiblyNullArgument */
            $pattern = '/'.addcslashes($this->uri, '/.').'$/';

            foreach ($matches[0] as $replaced) {
                $pattern = str_replace($replaced, '(.[aA-zZ0-9-_]+)', $pattern);
            }
        }
        /**
         * @psalm-suppress PossiblyNullArgument
         * @psalm-suppress MixedArgumentTypeCoercion
         */
        $route = new Route(
            $this->uri,
            $this->action,
            $this->methods,
            $this->name,
            $pattern,
            $parameters
        );

        $this->clear();

        return $route;
    }

    protected function clear(): void
    {
        $this->uri = null;
        $this->action = null;
        $this->methods = $this->methodsByDefault;
        $this->name = null;
    }
}
