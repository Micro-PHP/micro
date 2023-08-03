<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\EventEmitter;

use Micro\Framework\Autowire\AutowireHelperInterface;
use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\EventEmitter\EventEmitterFactoryInterface;
use Micro\Framework\BootDependency\Plugin\DependencyProviderInterface;
use Micro\Plugin\EventEmitter\Business\Facade\EventsFacade;
use Micro\Plugin\EventEmitter\Business\Factory\EventEmitterFactory;
use Micro\Plugin\EventEmitter\Business\Locator\EventListenerClassLocatorFactory;
use Micro\Plugin\EventEmitter\Business\Locator\EventListenerClassLocatorFactoryInterface;
use Micro\Plugin\EventEmitter\Business\Provider\ProviderFactory;
use Micro\Plugin\EventEmitter\Business\Provider\ProviderFactoryInterface;
use Micro\Plugin\Locator\Facade\LocatorFacadeInterface;

class EventEmitterPlugin implements DependencyProviderInterface
{
    private LocatorFacadeInterface $locatorFacade;

    private AutowireHelperInterface $autowireHelper;

    public function provideDependencies(Container $container): void
    {
        $container->register(EventsFacadeInterface::class, function (
            AutowireHelperInterface $autowireHelper,
            LocatorFacadeInterface $locatorFacade,
        ): EventsFacadeInterface {
            $this->locatorFacade = $locatorFacade;
            $this->autowireHelper = $autowireHelper;

            return $this->createFacade();
        });
    }

    protected function createFacade(): EventsFacadeInterface
    {
        return new EventsFacade($this->createEventEmitterFactory());
    }

    protected function createEventEmitterFactory(): EventEmitterFactoryInterface
    {
        return new EventEmitterFactory(
            $this->createProviderFactory()
        );
    }

    protected function createProviderFactory(): ProviderFactoryInterface
    {
        return new ProviderFactory(
            $this->autowireHelper,
            $this->createEventListenerClassLocatorFactory(),
        );
    }

    protected function createEventListenerClassLocatorFactory(): EventListenerClassLocatorFactoryInterface
    {
        return new EventListenerClassLocatorFactory(
            $this->locatorFacade
        );
    }
}
