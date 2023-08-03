<?php

namespace Micro\Plugin\Security\Business\Token\Encoder;

interface EncoderInterface
{
    /**
     * @param array $tokenData
     *
     * @return string
     */
    public function encode(array $tokenData): string;
}