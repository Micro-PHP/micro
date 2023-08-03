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

namespace Micro\Plugin\HttpCore\Business\Response\Transformer;

use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\HttpCore\Plugin\HttpResponseTransformerPlugin;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class ResponseTransformerFactory implements ResponseTransformerFactoryInterface
{
    public function __construct(
        private KernelInterface $kernel
    ) {
    }

    public function create(): ResponseTransformerInterface
    {
        $transformers = [];
        $iterator = $this->kernel->plugins(HttpResponseTransformerPlugin::class);
        /** @var HttpResponseTransformerPlugin $plugin */
        foreach ($iterator as $plugin) {
            $transformers[$plugin->weight()] = $plugin->createTransformer();
        }

        krsort($transformers);

        return new ResponseTransformer(array_values($transformers));
    }
}
