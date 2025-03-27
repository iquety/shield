<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayAccess;
use ArrayIterator;
use ArrayObject;
use Iterator;
use IteratorAggregate;
use stdClass;
use Stringable;

class AssertionSearchCase extends AssertionCase
{
    /**
     * Lista de valores para testar com estruturas em lista
     * array, stdClass, ArrayAccess, Iterator e IteratorAggregate
     * @return array<string,mixed>
     */
    protected function makeValueTypeList(): array
    {
        return [
            'false'          => false,
            'true'           => true,
            'integer 111'    => 111,      // inteiro
            'string 222'     => '222',    // inteiro string
            'decimal 22.5'   => 22.5,     // decimal
            'string 11.5'    => '11.5',   // decimal string
            'partial string' => 'ção!#'   // string
        ];
    }

    /**
     * Lista de valores para testar com estruturas em lista
     * array, stdClass, ArrayAccess, Iterator e IteratorAggregate
     * Os valores correspondem a versões inválidas dos valores de 'makeValueTypeList'
     * @return array<string,mixed>
     */
    protected function makeValueComparisonList(): array
    {
        return [
            'false'          => 'false',   // false em forma de string
            'true'           => 'true',    // true em forma de string
            'integer 111'    => '111',     // inteiro em forma de string
            'string 222'     => 222,       // inteiro string em forma de inteiro
            'decimal 22.5'   => '22.5',    // decimal em forma de string
            'string 11.5'    => 11.5,      // decimal string em forma de decimal
            'partial string' => 'ção'      // falta o !#
        ];
    }

    /**
     * @param array<string,mixed> $values
     * @return array<string,mixed>
     */
    protected function normalizeProperties(array $values): array
    {
        $normalizedValues = [];

        foreach ($values as $key => $value) {
            $normalizedValues['prop_' . preg_replace('/[^0-9a-z]/', '_', $key)] = $value;
        }

        return $normalizedValues;
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

    /** @param array<string,mixed> $value */
    protected function makeArrayAccessObject(array $value): ArrayAccess
    {
        return new class ($value) implements ArrayAccess {
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

    protected function makeIteratorObject(array $value): Iterator
    {
        return new ArrayIterator($value);
    }

    protected function makeIteratorAggregateObject(array $value): IteratorAggregate
    {
        return new ArrayObject($value);
    }

    protected function makeStdObject(array $value): stdClass
    {
        return (object)$value;
    }
}
