<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\ConfigurationHelper\Facade;

use Micro\Framework\BootConfiguration\Configuration\Exception\InvalidConfigurationException;

interface ConfigurationHelperFacadeInterface
{
    /**
     * Generate full path to file. For example:.
     *
     * Input: @HttpSecurityPlugin/Resource/routing/routing.xml
     * Output: /app/vendor/micro/plugin-http-security/src/Resource/routing/routing.xml
     *
     * @api
     *
     * @throws InvalidConfigurationException
     */
    public function resolvePath(string $relativePath): string;
}
