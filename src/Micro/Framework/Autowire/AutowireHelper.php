<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Framework\Autowire;

use Micro\Framework\Autowire\Exception\AutowireException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

readonly class AutowireHelper implements AutowireHelperInterface
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function autowire(string|array|callable $target): callable
    {
        return function () use ($target) {
            if (\is_array($target)) {
                $target = array_filter($target); // Don't allow [class-name::class-name] method
                $tc = \count($target);
                if (0 === $tc || $tc > 2) {
                    $this->throwAutowireException($target, '');
                }
            }

            try {
                if ($target instanceof \Closure) {
                    $arguments = $this->resolveArguments($target);

                    return \call_user_func($target, ...$arguments);
                }

                if (\is_string($target) && class_exists($target)) {
                    $arguments = $this->resolveArguments($target);

                    return new $target(...$arguments);
                }

                if (\is_object($target) && \is_callable($target)) {
                    $arguments = $this->resolveArguments([$target, '__invoke']);

                    return \call_user_func($target, ...$arguments);
                }

                if (!\is_array($target)) {
                    $this->throwAutowireException($target, '');
                }

                $object = $target[0] ?? null;
                $method = $target[1] ?? null;
                $arguments = null;

                if (\is_object($object)) {
                    if (!$method) {
                        if (!\is_callable($object)) {
                            $this->throwAutowireException($target, sprintf('Object `%s` is not callable.', \get_class($object)));
                        }

                        if (!($object instanceof \Closure)) {
                            $method = '__invoke';
                        }
                    }

                    if (!\is_string($method)) {
                        $this->throwAutowireException($target, '');
                    }

                    $arguments = $this->resolveArguments($object, $method);
                }

                if (($object instanceof \Closure) && !$method) {
                    return \call_user_func($object, ...$arguments);
                }

                if (!$object || !$method) {
                    $this->throwAutowireException($target, '');
                }

                if (\is_string($object)) {
                    $object = $this->resolveStringAsObject($object);
                }

                if (!\is_string($method)) {
                    $this->throwAutowireException($target, '');
                }

                return \call_user_func([$object, $method], ...$arguments); // @phpstan-ignore-line
            } catch (\InvalidArgumentException $exception) {
                $this->throwAutowireException($target, '', $exception);
            }
        };
    }

    /**
     * @throws ContainerExceptionInterface
     */
    protected function resolveStringAsObject(string $target): object
    {
        if (!class_exists($target)) {
            $this->throwAutowireException($target, 'The target class does not exist or no callable.');
        }

        return new $target(...$this->resolveArguments($target));
    }

    /**
     * @throws ContainerExceptionInterface
     *
     * @phpstan-ignore-next-line
     */
    protected function throwAutowireException(string|array|callable $target, string $message, \Throwable $parent = null): void
    {
        if (\is_array($target)) {
            $target = $target[0] ?? null;
        }

        if (\is_callable($target) && !\is_string($target)) {
            $target = 'Anonymous';
        }

        if (\is_object($target)) {
            $target = \get_class($target);
        }

        throw new AutowireException(sprintf('Can not autowire "%s". %s', $target, $message), 0, $parent);
    }

    protected function resolveArguments(string|array|object $target, ?string $method = null): array
    {
        if (\is_callable($target) && !$method && !\is_string($target)) {
            $ref = new \ReflectionFunction($target); // @phpstan-ignore-line

            return $this->resolveArgumentsFromReflectionParametersObject($ref->getParameters());
        }

        $reflectionClass = new \ReflectionClass($target); // @phpstan-ignore-line

        $reflectionClassMethod = null === $method ?
            $reflectionClass->getConstructor() :
            $reflectionClass->getMethod($method)
        ;

        if (null === $reflectionClassMethod) {
            return [];
        }

        return $this->resolveArgumentsFromReflectionParametersObject(
            $reflectionClassMethod->getParameters()
        );
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function resolveArgumentsFromReflectionParametersObject(array $reflectionParameters): array
    {
        $arguments = [];
        /** @var \ReflectionParameter $parameter */
        foreach ($reflectionParameters as $parameter) {
            $parameterType = $parameter->getType();
            $allowedNull = $parameter->isOptional();
            $parameterName = $parameter->getName();
            if (!$parameterType) {
                if (!$allowedNull) {
                    throw new \InvalidArgumentException(sprintf('The untyped argument `%s` cannot be autowired.', $parameterName));
                }

                $arguments[] = null;

                continue;
            }

            if (
                !$parameterType instanceof \ReflectionNamedType
            ) {
                throw new \InvalidArgumentException(sprintf('The argument `%s` has invalid type.', $parameterName));
            }

            $parameterTypeName = $parameterType->getName();

            $classImplements = class_implements($parameterTypeName);
            if (false === $classImplements) {
                $arguments[] = null;

                continue;
            }

            if (\in_array(ContainerInterface::class, $classImplements)) {
                $arguments[] = $this->container;

                continue;
            }

            $arguments[] = $this->container->get($parameterTypeName);
        }

        return $arguments;
    }
}
