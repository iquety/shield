<?php

declare(strict_types=1);

namespace Tests\Assertions;

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
}
