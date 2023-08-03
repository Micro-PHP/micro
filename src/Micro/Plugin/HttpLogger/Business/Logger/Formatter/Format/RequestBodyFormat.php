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
 * @author Stanislau Komar <kost@micro-php.net>
 */
class RequestBodyFormat extends AbstractFormat
{
    protected function getVarValue(Request $request, Response|null $response, ?\Throwable $exception): string
    {
        $type = (string) $request->headers->get('Content-Type');

        return match ($type) {
            'application/EDI-X12', 'application/javascript', 'application/EDIFACT', 'application/xhtml+xml' => sprintf('~%s Content~', $this->getTypeFrontName($type)),
            'application/zip' => '~ZIP Binary~',
            'application/x-shockwave-flash' => '~FLASH Binary~',
            'application/pdf' => '~PDF Binary~',
            'application/ogg' => 'OGG Binary',
            'audio/mpeg',
            'audio/x-ms-wma',
            'audio/vnd.rn-realaudio',
            'audio/x-wav' => sprintf('~Audio %s content~', $this->getTypeFrontName($type)),

            'application/vnd.oasis.opendocument.text',
            'application/vnd.oasis.opendocument.spreadsheet',
            'application/vnd.oasis.opendocument.presentation',
            'application/vnd.oasis.opendocument.graphics',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.mozilla.xul+xml' => sprintf('~VND %s~', $this->getTypeFrontName($type)),

            'video/mpeg',
            'video/mp4',
            'video/quicktime',
            'video/x-ms-wmv',
            'video/x-msvideo',
            'video/x-flv',
            'video/webm' => sprintf('~Video %s~', $this->getTypeFrontName($type)),

            'multipart/form-data',
            'multipart/mixed',
            'multipart/alternative',
            'multipart/related' => sprintf('~Multipart %s~', $this->getTypeFrontName($type)),

            default => $request->getContent(),
        };
    }

    protected function getVarName(): string
    {
        return 'request_body';
    }

    private function getTypeFrontName(string $type): string
    {
        $exploded = explode('/', $type);

        return mb_convert_case(array_pop($exploded), \MB_CASE_TITLE);
    }
}
