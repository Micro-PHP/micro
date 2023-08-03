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

namespace Micro\Plugin\Elastic\Tests\Unit\Facade;

use Elastic\Elasticsearch\ClientInterface;
use Micro\Plugin\Elastic\Client\Factory\ElasticClientFactoryInterface;
use Micro\Plugin\Elastic\Facade\ElasticFacade;
use PHPUnit\Framework\TestCase;

class ElasticFacadeTest extends TestCase
{
    public function testCreateClient(): void
    {
        $factory = $this->createMock(ElasticClientFactoryInterface::class);
        $client = $this->createMock(ClientInterface::class);
        $factory->expects($this->once())
            ->method('create')
            ->with('test')
            ->willReturn($client);

        $facade = new ElasticFacade(
            $factory
        );

        $this->assertEquals($client, $facade->createClient('test'));
    }
}
