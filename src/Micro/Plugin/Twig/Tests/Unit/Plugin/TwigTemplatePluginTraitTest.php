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

namespace Micro\Plugin\Twig\Tests\Unit\Plugin;

use Micro\Plugin\Twig\Plugin\TwigTemplatePluginInterface;
use Micro\Plugin\Twig\Plugin\TwigTemplatePluginTrait;
use PHPUnit\Framework\TestCase;

class TwigTemplatePluginTraitTest extends TestCase
{
    public function testRealClass()
    {
        $plugin = new ExampleTwigTemplatePluginTraitTest();

        $ref = new \ReflectionObject($plugin);

        $this->assertEquals('ExampleTwigTemplatePluginTraitTest', $plugin->getTwigNamespace());
        $this->assertEquals([
            \dirname($ref->getFileName()).'/templates',
        ], $plugin->getTwigTemplatePaths());
    }

    public function testAnonClass()
    {
        $plugin = new class() implements TwigTemplatePluginInterface {
            use TwigTemplatePluginTrait;
        };
        $ref = new \ReflectionObject($plugin);

        $this->assertNull($plugin->getTwigNamespace());
        $this->assertEquals([
            \dirname($ref->getFileName()).'/templates',
        ],
            $plugin->getTwigTemplatePaths());
    }
}

class ExampleTwigTemplatePluginTraitTest implements TwigTemplatePluginInterface
{
    use TwigTemplatePluginTrait;
}
