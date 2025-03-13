<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayAccess;
use Exception;
use Iquety\Shield\Assertion\NotContains;
use stdClass;
use Stringable;

class NotContainsTest extends AssertionCase
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @return array<string,array<int,mixed>>
     */
    public function validProvider(): array
    {
        $list = [];

        $list['string @Coração!# not contains $'] = ['@Coração!#', '$'];
        $list['string @Coração!# not contains @Cr'] = ['@Coração!#', '@Cr'];

        $list['stringable @Coração!# contains $']   = [new Exception('@Coração!#'), '$'];
        $list['stringable @Coração!# contains @Cr'] = [new Exception('@Coração!#'), '@Cr'];

        $list['object not valid'] = [new stdClass(), ''];
        $list['null not valid']   = [null, ''];
        $list['true not valid']   = [true, ''];
        $list['false not valid']  = [false, ''];

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

            $list["array not contains $type"] = [$typeValues, $comparison];

            $normalizedProperty = preg_replace('/[^0-9a-z]/', '_', $type);
            $propertyValues[$normalizedProperty] = $value;
        }

        foreach ($propertyValues as $property => $value) {
            $comparison = $typeSearch[$type];

            $stdObject = (object)$propertyValues;

            $list["stdClass not contains $property"] = [$stdObject, $comparison];
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

            $list["accessible contains $type"] = [$arrayAccessObject, $comparison];
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueNotContainsNeedle(mixed $value, float|int|string $needle): void
    {
        $assertion = new NotContains($value, $needle);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value, mixed $partial): array
    {
        if ($value instanceof Stringable) {
            $value = (string)$value;
        }

        $messageValue = $this->makeMessageValue($value);

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

        $list['string contains @Co'] = $this->makeIncorrectItem('@Coração!#', '@Co');
        $list['string contains ra'] = $this->makeIncorrectItem('@Coração!#', 'ra');
        $list['string contains ção!#'] = $this->makeIncorrectItem('@Coração!#', 'ção!#');

        $list['stringable @Coração!# contains @Co']   = $this->makeIncorrectItem(new Exception('@Coração!#'), '@Co');
        $list['stringable @Coração!# contains ra']    = $this->makeIncorrectItem(new Exception('@Coração!#'), 'ra');
        $list['stringable @Coração!# contains ção!#'] = $this->makeIncorrectItem(new Exception('@Coração!#'), 'ção!#');

        $typeValues = [
            'integer 111'    => 111,    // inteiro
            'string 222'     => '222',  // inteiro string
            'decimal 22.5'   => 22.5,   // decimal
            'string 11.5'    => '11.5', // decimal string
            'partial string' => 'ção!#' // string
        ];

        $propertyValues = [];

        foreach ($typeValues as $type => $value) {
            $list["array contains $type"] = $this->makeIncorrectItem($typeValues, $value);

            $normalizedProperty = preg_replace('/[^0-9a-z]/', '_', $type);
            $propertyValues[$normalizedProperty] = $value;
        }

        foreach ($propertyValues as $property => $value) {
            $stdObject = (object)$propertyValues;

            $list["stdClass contains $property"] = $this->makeIncorrectItem($stdObject, $value);
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

            $list["accessible contains $type"] = $this->makeIncorrectItem($arrayAccessObject, $value);
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueContainsNeedle(mixed $value, float|int|string $needle): void
    {
        $assertion = new NotContains($value, $needle);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must not contain $needle",
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueContainsNeedle(mixed $value, float|int|string $needle): void
    {
        $assertion = new NotContains($value, $needle);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must not contain $needle"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueContainsNeedleAndCustomMessage(
        mixed $value,
        float|int|string $needle,
        string $message
    ): void {
        $assertion = new NotContains($value, $needle);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueContainsNeedleWithCustomMessage(
        mixed $value,
        float|int|string $needle,
        string $message
    ): void {
        $assertion = new NotContains($value, $needle);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
