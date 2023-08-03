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

namespace Micro\Plugin\ConfigurationHelper\Tests\Unit\Business\Plugin;

use Micro\Plugin\ConfigurationHelper\Business\Plugin\PluginClassResolverCacheDecorator;
use Micro\Plugin\ConfigurationHelper\Business\Plugin\PluginClassResolverInterface;
use PHPUnit\Framework\TestCase;

class PluginClassResolverCacheDecoratorTest extends TestCase
{
    public function testResolve()
    {
        $alias = '@alias';
        $plugin = new \stdClass();

        $resolver = $this->createMock(PluginClassResolverInterface::class);
        $resolver->expects($this->once())->method('resolve')->with($alias)->willReturn($plugin);

        $decorator = new PluginClassResolverCacheDecorator(
            $resolver
        );

        $this->assertEquals($plugin, $decorator->resolve($alias));
        $this->assertEquals($plugin, $decorator->resolve($alias)); // cached
    }
}
