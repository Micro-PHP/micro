<?php

declare(strict_types=1);

namespace Micro\Plugin\Serializer\Plugin;

interface SerializerAdapterPluginInterface
{
    public function createSerializer(): SerializerInterface;
}
