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

use Symfony\Component\Validator\Constraints\Issn;

class IssnStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        $parent = parent::generateArguments($config);
        $current = [
            'caseSensitive' => $this->stringToBool($config['case_sensitive'] ?? 'false'),
            'requireHyphen' => $this->stringToBool($config['require_hyphen'] ?? 'false'),
        ];

        return array_filter(array_merge($parent, $current));
    }

    protected function getValidatorProperty(): string
    {
        return 'issn';
    }

    protected function getAttributeClassName(): string
    {
        return Issn::class;
    }
}
