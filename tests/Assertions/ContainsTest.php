<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayAccess;
use Exception;
use Iquety\Shield\Assertion\Contains;
use stdClass;
use Stringable;

class ContainsTest extends AssertionCase
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @return array<string,array<int,mixed>>
     */
    public function validProvider(): array
    {
        $list = [];

        $list['string @Coração!# contains @Co'] = ['@Coração!#', '@Co'];
        $list['string @Coração!# contains ra'] = ['@Coração!#', 'ra'];
        $list['string @Coração!# contains ção!#'] = ['@Coração!#', 'ção!#'];

        $list['string 123456 contains string 123'] = ['123456', '123'];
        $list['string 123456 contains string 345'] = ['123456', '345'];
        $list['string 123456 contains string 456'] = ['123456', '456'];

        $list['string 123456 contains integer 123'] = ['123456', 123];
        $list['string 123456 contains integer 345'] = ['123456', 345];
        $list['string 123456 contains integer 456'] = ['123456', 456];

        $list['integer 123456 contains string 123'] = [123456, '123'];
        $list['integer 123456 contains string 345'] = [123456, '345'];
        $list['integer 123456 contains string 456'] = [123456, '456'];

        $list['integer 123456 contains integer 123'] = [123456, 123];
        $list['integer 123456 contains integer 345'] = [123456, 345];
        $list['integer 123456 contains integer 456'] = [123456, 456];

        $list['string 12.3456 contains string 12.3'] = ['12.3456', '12.3'];
        $list['string 1234.56 contains string 34.5'] = ['1234.56', '34.5'];
        $list['string 12345.6 contains string 45.6'] = ['12345.6', '45.6'];

        $list['string 12.3456 contains decimal 12.3'] = ['12.3456', 12.3];
        $list['string 1234.56 contains decimal 34.5'] = ['1234.56', 34.5];
        $list['string 12345.6 contains decimal 45.6'] = ['12345.6', 45.6];

        $list['decimal 12.3456 contains string 12.3'] = [12.3456, '12.3'];
        $list['decimal 1234.56 contains string 34.5'] = [1234.56, '34.5'];
        $list['decimal 12345.6 contains string 45.6'] = [12345.6, '45.6'];

        $list['decimal 12.3456 contains decimal 12.3'] = [12.3456, 12.3];
        $list['decimal 1234.56 contains decimal 34.5'] = [1234.56, 34.5];
        $list['decimal 12345.6 contains decimal 45.6'] = [12345.6, 45.6];

        $list['stringable @Coração!# contains @Co']   = [new Exception('@Coração!#'), '@Co'];
        $list['stringable @Coração!# contains ra']    = [new Exception('@Coração!#'), 'ra'];
        $list['stringable @Coração!# contains ção!#'] = [new Exception('@Coração!#'), 'ção!#'];

        $typeValues = [
            'integer 111' => 111,    // inteiro
            'string 222' => '222',  // inteiro string
            'decimal 22.5' => 22.5,   // decimal
            'string 11.5' => '11.5', // decimal string
            'partial string' => 'ção!#' // string
        ];

        $propertyValues = [];

        foreach ($typeValues as $type => $value) {
            $list["array contains $type"] = [$typeValues, $value];

            $normalizedProperty = preg_replace('/[^0-9a-z]/', '_', $type);
            $propertyValues[$normalizedProperty] = $value;
        }

        foreach ($propertyValues as $property => $value) {
            $stdObject = (object)$propertyValues;

            $list["stdClass contains $property"] = [$stdObject, $value];
        }

        foreach ($typeValues as $type => $value) {
            $arrayAccessObject = new class ($typeValues) implements ArrayAccess {
                /** @param array<int|string,mixed> $values */
                public function __construct(private array $values)
                {
                }

                public function offsetExists(mixed $offset): bool
                {
                    return isset($this->values[$offset]);
                }

                public function offsetGet(mixed $offset): mixed
                {
                    return $this->values[$offset] ?? null;
                }

                public function offsetSet(mixed $offset, mixed $value): void
                {
                    $this->values[$offset] = $value;
                }

                public function offsetUnset(mixed $offset): void
                {
                    unset($this->values[$offset]);
                }
            };

            $list["accessible contains $type"] = [$arrayAccessObject, $value];
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueContainsNeedle(mixed $value, float|int|string $needle): void
    {
        $assertion = new Contains($value, $needle);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value, mixed $partial): array
    {
        if ($value instanceof Stringable) {
            $value = (string)$value;
        }

        $messageValue = is_array($value) === true
            ? $this->makeArrayMessage($value)
            : $this->makeMessageValue($value);

        return [
            $value,
            $partial,
            "O valor $messageValue está errado" // mensagem personalizada
        ];
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @return array<string,array<int,mixed>>
     */
    public function invalidProvider(): array
    {
        $list = [];

        $list['string @Coração!# not contains $']   = $this->makeIncorrectItem('@Coração!#', '$');
        $list['string @Coração!# not contains @Cr'] = $this->makeIncorrectItem('@Coração!#', '@Cr');

        $list['stringable @Coração!# contains $']   = $this->makeIncorrectItem(new Exception('@Coração!#'), '$');
        $list['stringable @Coração!# contains @Cr'] = $this->makeIncorrectItem(new Exception('@Coração!#'), '@Cr');

        $list['object not valid'] = $this->makeIncorrectItem(new stdClass(), '');
        $list['null not valid']   = $this->makeIncorrectItem(null, '');
        $list['true not valid']   = $this->makeIncorrectItem(true, '');
        $list['false not valid']  = $this->makeIncorrectItem(false, '');

        $typeValues = [
            'integer 111'    => 111,      // inteiro
            'string 222'     => '222',    // inteiro string
            'decimal 22.5'   => 22.5,     // decimal
            'string 11.5'    => '11.5',   // decimal string
            'partial string' => 'ção!#'   // string
        ];

        $typeSearch = [
            'integer 111'    => '111',     // inteiro
            'string 222'     => 222,   // inteiro string
            'decimal 22.5'   => '22.5',     // decimal
            'string 11.5'    => 11.5,   // decimal string
            'partial string' => '$'     // string
        ];

        $propertyValues = [];

        foreach ($typeValues as $type => $value) {
            $comparison = $typeSearch[$type];

            $list["array not contains $type"] = $this->makeIncorrectItem($typeValues, $comparison);

            $normalizedProperty = preg_replace('/[^0-9a-z]/', '_', $type);
            $propertyValues[$normalizedProperty] = $value;
        }

        foreach ($propertyValues as $property => $value) {
            $comparison = $typeSearch[$type];

            $stdObject = (object)$propertyValues;

            $list["stdClass not contains $property"] = $this->makeIncorrectItem($stdObject, $comparison);
        }

        foreach ($typeValues as $type => $value) {
            $arrayAccessObject = new class ($typeValues) implements ArrayAccess {
                /** @param array<int|string,mixed> $values */
                public function __construct(private array $values)
                {
                }

                public function offsetExists(mixed $offset): bool
                {
                    return isset($this->values[$offset]);
                }

                public function offsetGet(mixed $offset): mixed
                {
                    return $this->values[$offset] ?? null;
                }

                public function offsetSet(mixed $offset, mixed $value): void
                {
                    $this->values[$offset] = $value;
                }

                public function offsetUnset(mixed $offset): void
                {
                    unset($this->values[$offset]);
                }
            };

            $comparison = $typeSearch[$type];

            $list["accessible contains $type"] = $this->makeIncorrectItem($arrayAccessObject, $comparison);
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotContainsNeedle(mixed $value, float|int|string $needle): void
    {
        $assertion = new Contains($value, $needle);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), "Value must contain $needle");
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueNotContainsNeedle(mixed $value, float|int|string $needle): void
    {
        $assertion = new Contains($value, $needle);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must contain $needle"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueNotContainsNeedleWithCustomMessage(
        mixed $value,
        float|int|string $needle,
        string $message
    ): void {
        $assertion = new Contains($value, $needle);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotContainsNeedleWithCustomMessage(
        mixed $value,
        float|int|string $needle,
        string $message
    ): void {
        $assertion = new Contains($value, $needle);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
