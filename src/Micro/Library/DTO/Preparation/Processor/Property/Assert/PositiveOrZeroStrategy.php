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

namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;

use Symfony\Component\Validator\Constraints\PositiveOrZero;

class PositiveOrZeroStrategy extends AbstractConstraintStrategy
{
    protected function getValidatorProperty(): string
    {
        return 'positive_or_zero';
    }

    protected function getAttributeClassName(): string
    {
        return PositiveOrZero::class;
    }
}
