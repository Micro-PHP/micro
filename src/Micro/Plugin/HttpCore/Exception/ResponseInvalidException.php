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

namespace Micro\Plugin\HttpCore\Exception;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class ResponseInvalidException extends \RuntimeException
{
    private mixed $responseData;

    public function __construct(mixed $responseData, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct('Invalid response object type.', $code, $previous);

        $this->responseData = $responseData;
    }

    public function getResponseData(): mixed
    {
        return $this->responseData;
    }
}
