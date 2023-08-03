<?php

namespace Micro\Plugin\Security\Token;


interface TokenInterface
{
    /**
     * @return array
     */
    public function getParameters(): array;

    /**
     * @param string $parameterName
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public function getParameter(string $parameterName, mixed $default): mixed;

    /**
     * @return string
     */
    public function getSource(): string;
}