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

namespace Micro\Plugin\Twig\Tests\Unit\Business\Environment;

use Micro\Framework\BootConfiguration\Configuration\DefaultApplicationConfiguration;
use Micro\Plugin\Twig\Business\Environment\EnvironmentFactory;
use Micro\Plugin\Twig\Business\Loader\LoaderProcessorInterface;
use Micro\Plugin\Twig\TwigPluginConfiguration;
use PHPUnit\Framework\TestCase;
use Twig\Environment;

class EnvironmentFactoryTest extends TestCase
{
    public function testCreate()
    {
        $appConfig = new DefaultApplicationConfiguration([]);
        $pluginConfig = new TwigPluginConfiguration($appConfig);

        $envLoader = $this->createMock(LoaderProcessorInterface::class);

        $envFactory = new EnvironmentFactory(
            $pluginConfig,
            $envLoader,
        );

        $twigEnv = $envFactory->create();

        $this->assertInstanceOf(Environment::class, $twigEnv);
    }
}
