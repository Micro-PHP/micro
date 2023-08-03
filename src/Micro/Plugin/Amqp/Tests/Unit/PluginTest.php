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

namespace Micro\Plugin\Amqp\Tests\Unit;

use Micro\Framework\KernelApp\AppKernel;
use Micro\Plugin\Amqp\AmqpPlugin;
use Micro\Plugin\Amqp\Business\Consumer\Processor\ConsumerProcessorInterface;
use Micro\Plugin\Amqp\Facade\AmqpFacadeInterface;
use Micro\Plugin\Amqp\Tests\Unit\Consumer\TestConsumer;
use PHPUnit\Framework\TestCase;

class PluginTest extends TestCase
{
    public function testPlugin(): void
    {
        $kernel = new AppKernel([], [
            AmqpPlugin::class,
            TestPluginMock::class,
        ]);

        $kernel->run();
        $facade = $kernel->container()->get(AmqpFacadeInterface::class);
        foreach ($facade->locateConsumers() as $consumerClass) {
            $this->assertTrue(class_exists($consumerClass));
            $this->assertTrue(\in_array(ConsumerProcessorInterface::class, class_implements($consumerClass)));
        }

        $testConsumer = $facade->locateConsumer('test');

        $this->assertEquals(TestConsumer::class, $testConsumer);
    }
}
