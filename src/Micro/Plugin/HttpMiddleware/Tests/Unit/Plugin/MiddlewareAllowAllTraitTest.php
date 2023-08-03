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

namespace Micro\Plugin\HttpMiddleware\Tests\Unit\Plugin;

use Micro\Plugin\HttpMiddleware\Plugin\HttpMiddlewareOrderedPluginInterface;
use Micro\Plugin\HttpMiddleware\Plugin\HttpMiddlewarePluginInterface;
use Micro\Plugin\HttpMiddleware\Plugin\MiddlewareAllowAllTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class MiddlewareAllowAllTraitTest extends TestCase
{
    private HttpMiddlewarePluginInterface $plugin;

    protected function setUp(): void
    {
        $this->plugin = new class() implements HttpMiddlewareOrderedPluginInterface {
            use MiddlewareAllowAllTrait;

            public function processMiddleware(Request $request): void
            {
            }
        };
    }

    public function testGetRequestMatchMethods()
    {
        $this->assertEquals(['get', 'post', 'patch', 'put', 'delete'], $this->plugin->getRequestMatchMethods());
    }

    public function testGetRequestMatchPath()
    {
        $this->assertEquals('^/', $this->plugin->getRequestMatchPath());
    }

    public function testGetMiddlewarePriority()
    {
        $this->assertEquals(0, $this->plugin->getMiddlewarePriority());
    }
}
