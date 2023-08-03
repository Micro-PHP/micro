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

namespace Micro\Plugin\ConfigurationHelper\Tests\Unit\Business\Path;

use Micro\Plugin\ConfigurationHelper\Business\Path\PathResolverCacheDecorator;
use Micro\Plugin\ConfigurationHelper\Business\Path\PathResolverInterface;
use PHPUnit\Framework\TestCase;

class PathResolverCacheDecoratorTest extends TestCase
{
    public function testResolve()
    {
        $acceptedVal = '/path/to/plugin';
        $alias = '@test';
        $pathResolverMock = $this->createMock(PathResolverInterface::class);
        $pathResolverMock
            ->expects($this->once())
            ->method('resolve')
            ->with($alias)
            ->willReturn($acceptedVal);

        $cachedDecorator = new PathResolverCacheDecorator(
            $pathResolverMock
        );

        $resultOriginal = $cachedDecorator->resolve($alias);
        $resultCached = $cachedDecorator->resolve($alias);

        $this->assertEquals($acceptedVal, $resultOriginal);
        $this->assertEquals($acceptedVal, $resultCached);
    }
}
