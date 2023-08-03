<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\HttpCore\Tests\Unit\Business\Route;

use Micro\Plugin\HttpCore\Business\Route\Route;
use Micro\Plugin\HttpCore\Business\Route\RouteInterface;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public const URI = '/{test}';
    public const PARAMS = ['test'];

    public const PATTERN = '/\/(.[aA-zZ]+)/';

    public const METHODS = ['GET', 'POST'];

    public const NAME = 'test';

    private RouteInterface $route;

    protected function setUp(): void
    {
        $this->route = new Route(
            self::URI,
            function () { return 1; },
            self::METHODS,
            self::NAME,
            self::PATTERN,
            self::PARAMS,
        );
    }

    public function testGetUri()
    {
        $this->assertEquals(self::URI, $this->route->getUri());
    }

    public function testGetParameters()
    {
        $this->assertEquals(self::PARAMS, $this->route->getParameters());
    }

    public function testGetAction()
    {
        $action = $this->route->getController();
        $this->assertIsCallable($action);

        $this->assertEquals(1, \call_user_func($action));
    }

    public function testGetPattern()
    {
        $this->assertEquals(self::PATTERN, $this->route->getPattern());
    }

    public function testGetMethods()
    {
        $this->assertEquals(self::METHODS, $this->route->getMethods());
    }

    public function testGetName()
    {
        $this->assertEquals(self::NAME, $this->route->getName());
    }
}
