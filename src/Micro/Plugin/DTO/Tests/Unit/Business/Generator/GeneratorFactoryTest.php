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

namespace Micro\Plugin\DTO\Tests\Unit\Business\Generator;

use Micro\Plugin\DTO\Business\FileLocator\FileLocatorFactoryInterface;
use Micro\Plugin\DTO\Business\Generator\GeneratorFactory;
use Micro\Plugin\DTO\DTOPluginConfigurationInterface;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class GeneratorFactoryTest extends TestCase
{
    public function testCreate()
    {
        $logger = $this->createMock(LoggerInterface::class);
        $loggerFacade = $this->createMock(LoggerFacadeInterface::class);
        $loggerFacade
            ->expects($this->once())
            ->method('getLogger')
            ->with('test')
            ->willReturn($logger);

        $pluginCfg = $this->createMock(DTOPluginConfigurationInterface::class);
        $pluginCfg
            ->expects($this->once())
            ->method('getLoggerName')
            ->willReturn('test');

        $fileLocatorFactory = $this->createMock(FileLocatorFactoryInterface::class);

        $factory = new GeneratorFactory(
            $fileLocatorFactory,
            $pluginCfg,
            $loggerFacade,
        );

        $generator = $factory->create();

        $this->assertNotNull($generator);

        $generator->generate();
    }
}
