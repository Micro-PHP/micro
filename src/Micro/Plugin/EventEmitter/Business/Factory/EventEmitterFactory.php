<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\EventEmitter\Business\Factory;

use Micro\Framework\EventEmitter\EventEmitterFactory as BaseEventEmitterFactory;
use Micro\Framework\EventEmitter\EventEmitterInterface;
use Micro\Plugin\EventEmitter\Business\Provider\ProviderFactoryInterface;

class EventEmitterFactory extends BaseEventEmitterFactory
{
    public function __construct(
        private readonly ProviderFactoryInterface $providerFactoryInterface
    ) {
    }

    public function create(): EventEmitterInterface
    {
        $emitter = parent::create();

        $emitter->addListenerProvider(
            $this->providerFactoryInterface->create()
        );

        return $emitter;
    }
}
