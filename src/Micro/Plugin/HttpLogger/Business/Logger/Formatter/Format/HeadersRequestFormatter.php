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

namespace Micro\Plugin\HttpLogger\Business\Logger\Formatter\Format;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
class HeadersRequestFormatter extends AbstractHeaderFormatter
{
    /**
     * @var string[]
     */
    private readonly array $securedHeadersList;

    /**
     * @param string[] $securedHeadersList
     */
    public function __construct(
        array $securedHeadersList
    ) {
        $this->securedHeadersList = array_map('mb_strtolower', $securedHeadersList);
    }

    protected function getPrefix(): string
    {
        return 'request';
    }

    protected function getValue(Request $request, ?Response $response, string $matchedVar): string
    {
        if (!$matchedVar) {
            return '';
        }
        $isSingleVar = true;
        if ('*' === $matchedVar) {
            $headersArray = $request->headers->all();
            $isSingleVar = false;
        } else {
            $tmpHeaderValue = $request->headers->get($matchedVar);

            $headersArray = [$matchedVar => $tmpHeaderValue];
        }

        $headersArray = array_change_key_case($headersArray);
        foreach ($this->securedHeadersList as $securedHeader) {
            if (!\array_key_exists($securedHeader, $headersArray)) {
                continue;
            }
            /** @var string[] $securedHeaderValue */
            $securedHeaderValue = $headersArray[$securedHeader];

            $headersArray[$securedHeader] = array_map(fn (mixed $value) => '** Secured **', $securedHeaderValue);
        }

        if ($isSingleVar) {
            $headersArray = array_values($headersArray);
            if (1 === \count($headersArray)) {
                $tmpValue = $headersArray[0];
                if (!\is_array($tmpValue)) {
                    return (string) $tmpValue;
                }
            }
        }

        return (string) json_encode($headersArray);
    }
}
