<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayAccess;
use ArrayIterator;
use ArrayObject;
use Iterator;
use IteratorAggregate;
use ReflectionObject;
use stdClass;
use Stringable;
use Tests\TestCase;

/** @SuppressWarnings(PHPMD.NumberOfChildren) */
class AssertionCase extends TestCase
{
    protected function makeObjectMessage(object $object): string
    {
        $state = [];

        $reflector = new ReflectionObject($object);
        $properties = $reflector->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);

            $state[$property->getName()] = $property->getValue($object);
        }

        return sprintf(
            '%s:%s',
            $object::class,
            str_replace([':', '{', '}'], ['=>', '[', ']'], (string)json_encode($state))
        );
    }

    /** @param array<int|string,mixed> $value */
    protected function makeArrayMessage(array $value): string
    {
        return str_replace([':', '{', '}'], ['=>', '[', ']'], (string)json_encode($value));
    }

    protected function makeMessageValue(mixed $value): string
    {
        if (is_bool($value) && $value === true) {
            return 'true';
        }

        if (is_bool($value) && $value === false) {
            return 'false';
        }

        if ($value === null) {
            return 'null';
        }

        switch (gettype($value)) {
            case 'array':
                $messageValue = $this->makeArrayMessage($value);

                break;
            case 'object':
                $messageValue = $this->makeObjectMessage($value);

                break;
            default:
                $messageValue = (string)$value;
        };

        return $messageValue;
    }

    protected function makeStdProperty(string $key): string
    {
        return 'prop_' . preg_replace('/[^0-9a-z]/', '_', $key);
    }

    protected function makeStringableObject(string $value): Stringable
    {
        return new class ($value) implements Stringable {
            public function __construct(protected string $value)
            {
            }

            public function __toString(): string
            {
                return $this->value;
            }
        };
    }

    /**
     * @param array<int|string,mixed> $value
     * @return ArrayAccess<int|string,mixed>
     */
    protected function makeArrayAccessObject(array $value): ArrayAccess
    {
        return new class ($value) implements ArrayAccess {
            /** @param array<int|string,mixed> $value */
            public function __construct(private array $value)
            {
            }

            public function offsetExists($offset): bool
            {
                return isset($this->value[$offset]);
            }

            public function offsetGet($offset): mixed
            {
                return $this->value[$offset] ?? null;
            }

            public function offsetSet($offset, $value): void
            {
                $this->value[$offset] = $value;
            }

            public function offsetUnset($offset): void
            {
                unset($this->value[$offset]);
            }
        };
    }

    /**
     * @param array<int|string,mixed> $value
     * @return Iterator<int|string,mixed>
     */
    protected function makeIteratorObject(array $value): Iterator
    {
        return new ArrayIterator($value);
    }

    /**
     * @param array<int|string,mixed> $value
     * @return IteratorAggregate<int|string,mixed>
     */
    protected function makeIteratorAggregateObject(array $value): IteratorAggregate
    {
        return new ArrayObject($value);
    }

    /** @param array<int|string,mixed> $value */
    protected function makeStdObject(array $value): stdClass
    {
        return (object)$value;
    }
}
