<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Amqp\Business\Publisher;

class PublisherManager implements PublisherManagerInterface
{
    /**
     * @var PublisherInterface[]
     */
    private array $publisherCollection;

    public function __construct(private readonly PublisherFactoryInterface $publisherFactory)
    {
        $this->publisherCollection = [];
    }

    /**
     * {@inheritDoc}
     */
    public function publish(
        string $message,
        string $publisherName,
        string $routingKey = '',
        array $options = []
    ): void {
        $this->getPublisher($publisherName)->publish($message, $routingKey, $options);
    }

    protected function getPublisher(string $publisherName): PublisherInterface
    {
        if (!empty($this->publisherCollection[$publisherName])) {
            return $this->publisherCollection[$publisherName];
        }

        return $this->publisherCollection[$publisherName] = $this->publisherFactory->create($publisherName);
    }
}
