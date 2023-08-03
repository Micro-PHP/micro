<?php

namespace Micro\Plugin\Security\Business\Token\Configuration;

readonly class TokenConfiguration
{
    /**
     * @var int
     */
    private int $createdAt;

    /**
     * @param array $parameters
     * @param int $lifetime
     */
    public function __construct(
        private array $parameters,
        private int $lifetime = 0
    )
    {
        $this->createdAt = time();
    }

    /**
     * @return int
     */
    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getLifetime(): int
    {
        return $this->lifetime;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}