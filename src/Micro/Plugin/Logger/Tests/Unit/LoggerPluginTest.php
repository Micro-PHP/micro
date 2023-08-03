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

namespace Micro\Plugin\Logger\Tests\Unit;

use Micro\Component\DependencyInjection\Autowire\ContainerAutowire;
use Micro\Framework\DependencyInjection\Container;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;
use Micro\Plugin\Logger\LoggerPlugin;
use Micro\Plugin\Logger\LoggerPluginConfiguration;

/**
 * @author GTPChat
 */
class LoggerPluginTest extends \PHPUnit\Framework\TestCase
{
    public function testProvideDependencies()
    {
        $kernelMock = $this->createMock(KernelInterface::class);
        $container = new ContainerAutowire(new Container());
        $container->register(KernelInterface::class, fn () => $kernelMock);

        $configMock = $this->createMock(LoggerPluginConfiguration::class);

        $loggerPlugin = new LoggerPlugin();
        $loggerPlugin->setConfiguration($configMock);
        $loggerPlugin->provideDependencies($container);

        $this->assertTrue($container->has(LoggerFacadeInterface::class));
        $loggerFacade = $container->get(LoggerFacadeInterface::class);
        $this->assertInstanceOf(LoggerFacadeInterface::class, $loggerFacade);
    }
}
