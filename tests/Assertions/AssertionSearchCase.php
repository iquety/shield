<?php

declare(strict_types=1);

namespace Tests\Assertions;

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
            'null'           => null,
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
            'null'           => 'null', // null em forma de string
            'false'          => 'false',// false em forma de string
            'true'           => 'true', // true em forma de string
            'integer 111'    => '111',  // inteiro em forma de string
            'string 222'     => 222,    // inteiro string em forma de inteiro
            'decimal 22.5'   => '22.5', // decimal em forma de string
            'string 11.5'    => 11.5,   // decimal string em forma de decimal
            'partial string' => 'ção'   // falta o !#
        ];
    }

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

    protected function popArrayValue(array &$values, array &$comparison = []): mixed
    {
        $lastValue = $comparison !== []
            ? $comparison[array_key_last($comparison)]
            : $values[array_key_last($values)];

        array_pop($values);

        return $lastValue;
    }

    protected function popStdValue(array &$values, array &$comparison = []): mixed
    {
        $lastValue = $comparison !== []
            ? $comparison[array_key_last($comparison)]
            : $values[array_key_last($values)];

        array_pop($values);

        return $lastValue;
    }

    protected function popArrayAccessValue(array &$values, array &$comparison = []): mixed
    {
        $lastValue = $comparison !== []
            ? $comparison[array_key_last($comparison)]
            : $values[array_key_last($values)];

        array_pop($values);

        return $lastValue;
    }

    protected function popIteratorAggrValue(array &$values, array &$comparison = []): mixed
    {
        $lastValue = $comparison !== []
            ? $comparison[array_key_last($comparison)]
            : $values[array_key_last($values)];

        array_pop($values);

        return $lastValue;
    }

    protected function popIteratorValue(array &$values, array &$comparison = []): mixed
    {
        $lastValue = $comparison !== []
            ? $comparison[array_key_last($comparison)]
            : $values[array_key_last($values)];

        array_pop($values);

        return $lastValue;
    }

    protected function shiftArrayValue(array &$values, array &$comparison = []): mixed
    {
        $firstValue = $comparison !== []
            ? $comparison[array_key_first($comparison)]
            : $values[array_key_first($values)];

        array_shift($values);

        return $firstValue;
    }

    protected function shiftStdValue(array &$values, array &$comparison = []): mixed
    {
        $firstValue = $comparison !== []
            ? $comparison[array_key_first($comparison)]
            : $values[array_key_first($values)];

        array_shift($values);

        return $firstValue;
    }

    protected function shiftArrayAccessValue(array &$values, array &$comparison = []): mixed
    {
        $firstValue = $comparison !== []
            ? $comparison[array_key_first($comparison)]
            : $values[array_key_first($values)];

        array_shift($values);

        return $firstValue;
    }

    protected function shiftIteratorAggrValue(array &$values, array &$comparison = []): mixed
    {
        $firstValue = $comparison !== []
            ? $comparison[array_key_first($comparison)]
            : $values[array_key_first($values)];

        array_shift($values);

        return $firstValue;
    }

    protected function shiftIteratorValue(array &$values, array &$comparison = []): mixed
    {
        $firstValue = $comparison !== []
            ? $comparison[array_key_first($comparison)]
            : $values[array_key_first($values)];

        array_shift($values);

        return $firstValue;
    }

    protected function makeStringableObject(string $value): Stringable
    {
        return new class($value) implements Stringable {
            public function __construct(protected string $value) { }

            public function __toString(): string
            {
                return $this->value;
            }
        };
    }
}
