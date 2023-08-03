<?php

namespace Micro\Plugin\Uuid;

use Micro\Plugin\Uuid\Business\UuidExtractorInterface;
use Micro\Plugin\Uuid\Business\UuidGeneratorInterface;

interface UuidFacadeInterface extends UuidGeneratorInterface, UuidExtractorInterface
{
}
