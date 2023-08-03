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

namespace Micro\Plugin\HttpExceptionsDev\Business\Exception\Renderer;

use Micro\Plugin\HttpExceptionsDev\Configuration\HttpExceptionResponseDevPluginConfigurationInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <head.trackingsoft@gmail.com>
 */
readonly class RendererFactory implements RendererFactoryInterface
{
    public function __construct(
        private HttpExceptionResponseDevPluginConfigurationInterface $pluginConfiguration
    ) {
    }

    public function create(Request $request): RendererInterface
    {
        $format = $request->get('_format');

        return match ($format) {
            'json' => new JsonRenderer(),
            default => new HtmlRenderer(
                $this->pluginConfiguration->getProjectDir(),
            ),
        };
    }
}
