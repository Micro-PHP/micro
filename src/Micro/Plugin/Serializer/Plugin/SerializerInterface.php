<?php

declare(strict_types=1);

namespace Micro\Plugin\Serializer\Plugin;

use Micro\Plugin\Serializer\Business\Context\SerializerContextInterface;
use Micro\Plugin\Serializer\Business\Serializer\SerializerInterface as BareSerializerInterface;

interface SerializerInterface extends BareSerializerInterface
{
    public function supports(SerializerContextInterface $serializerContext): bool;
}
