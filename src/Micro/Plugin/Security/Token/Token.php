<?php

namespace Micro\Plugin\Security\Token;

readonly class Token implements TokenInterface
{
    /**
     * @param string $source
     * @param array $parameters
     */
    public function __construct(
        private string $source,
        private array $parameters
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * {@inheritDoc}
     */
    public function getParameter(string $parameterName, mixed $default): mixed
    {
        return $this->parameters[$parameterName] ?? $default;
    }

    /**
     * {@inheritDoc}
     */
    public function getSource(): string
    {
        return $this->source;
    }
}