<?php

declare(strict_types=1);

namespace Tests\Assertions;

use InvalidArgumentException;
use Iquety\Shield\Assertion\Contains;
use stdClass;
use Stringable;

/** @SuppressWarnings(PHPMD.TooManyPublicMethods) */
class ContainsTest extends AssertionSearchCase
{
    /** @return array<string,array<mixed>> */
    public function invalidValueProvider(): array
    {
        $list = [];

        $list['null is invalid value']    = [null];
        $list['integer is invalid value'] = [123];
        $list['float is invalid value']   = [12.3];
        $list['true is invalid value']    = [true];
        $list['false is invalid value']   = [false];

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidValueProvider
     */
    public function valueIsInvalid(mixed $value): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value is not valid');

        $assertion = new Contains($value, 'string');

        $assertion->isValid();
    }

    /** @return array<string,array<mixed>> */
    public function invalidNeedleProvider(): array
    {
        $list = [];

        $list['null is invalid needle for string']    = [null];
        $list['integer is invalid needle for string'] = [123];
        $list['float is invalid needle for string']   = [12.3];
        $list['true is invalid needle for string']    = [true];
        $list['false is invalid needle for string']   = [false];
        $list['array is invalid needle for string']   = [['x']];
        $list['object is invalid needle for string']  = [new stdClass()];

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidNeedleProvider
     */
    public function needleForStringIsInvalid(mixed $needle): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value needle is not a valid search value for a string');

        $assertion = new Contains('string', $needle);

        $assertion->isValid();
    }

    /** @test */
    public function needleForListIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Null is not a valid search value for a list');

        $assertion = new Contains(['x'], null);

        $assertion->isValid();
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @return array<string,array<int,mixed>>
     */
    public function validProvider(): array
    {
        $list = [];

        // | string            | string                          |
        // | Stringable        | string                          |
        // | array             | string, int, float, true, false |
        // | ArrayAccess       | string, int, float, true, false |
        // | Iterator          | string, int, float, true, false |
        // | IteratorAggregate | string, int, float, true, false |
        // | stdClass          | string, int, float, true, false |

        $list['string @Coração!# contains @Co']       = ['@Coração!#', '@Co'];
        $list['string @Coração!# contains ra']        = ['@Coração!#', 'ra'];
        $list['string @Coração!# contains ção!#']     = ['@Coração!#', 'ção!#'];
        $list['string 123456 contains 123']           = ['123456', '123'];
        $list['string 123456 contains 345']           = ['123456', '345'];
        $list['string 123456 contains 456']           = ['123456', '456'];
        $list['stringable @Coração!# contains @Co']   = [$this->makeStringableObject('@Coração!#'), '@Co'];
        $list['stringable @Coração!# contains ra']    = [$this->makeStringableObject('@Coração!#'), 'ra'];
        $list['stringable @Coração!# contains ção!#'] = [$this->makeStringableObject('@Coração!#'), 'ção!#'];

        $valueTypes = $this->makeValueTypeList();

        foreach ($valueTypes as $label => $needle) {
            $list["array contains $label"] = [$valueTypes, $needle];
        }

        foreach ($valueTypes as $label => $needle) {
            $label = $this->makeStdProperty($label);
            $stdClassValue = $this->makeStdObject($valueTypes);
            $list["stdClass contains value of property $label"] = [$stdClassValue, $needle];
        }

        foreach ($valueTypes as $label => $needle) {
            $arrayAccessValue = $this->makeArrayAccessObject($valueTypes);
            $list["ArrayAccess contains $label"] = [$arrayAccessValue, $needle];
        }

        foreach ($valueTypes as $label => $needle) {
            $iteratorValue = $this->makeIteratorObject($valueTypes);
            $list["Iterator contains $label"] = [$iteratorValue, $needle];
        }

        foreach ($valueTypes as $label => $needle) {
            $iteratorAggrValue = $this->makeIteratorAggregateObject($valueTypes);
            $list["IteratorAggregate contains $label"] = [$iteratorAggrValue, $needle];
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueContainsNeedle(mixed $value, mixed $needle): void
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

        // | string            | string                          |
        // | Stringable        | string                          |
        // | array             | string, int, float, true, false |
        // | ArrayAccess       | string, int, float, true, false |
        // | Iterator          | string, int, float, true, false |
        // | IteratorAggregate | string, int, float, true, false |
        // | stdClass          | string, int, float, true, false |

        $stringable = $this->makeStringableObject('@Coração!#');

        $list['string @Coração!# not contains $']     = $this->makeIncorrectItem('@Coração!#', '$');
        $list['string @Coração!# not contains @Cr']   = $this->makeIncorrectItem('@Coração!#', '@Cr');
        $list['stringable @Coração!# not contains $'] = $this->makeIncorrectItem($stringable, '$');
        $list['stringable @Coração!# not contains $'] = $this->makeIncorrectItem($stringable, '@Cr');

        $valueTypes = $this->makeValueTypeList();

        $valueTypesComparison = $this->makeValueComparisonList();

        foreach ($valueTypesComparison as $label => $value) {
            $list["array not contains $label"] = $this->makeIncorrectItem($valueTypes, $value);
        }

        foreach ($valueTypesComparison as $label => $value) {
            $label = $this->makeStdProperty($label);
            $stdClassValue = $this->makeStdObject($valueTypes);
            $list["stdClass not contains value of property $label"] = $this->makeIncorrectItem($stdClassValue, $value);
        }

        foreach ($valueTypesComparison as $label => $value) {
            $arrayAccessValue = $this->makeArrayAccessObject($valueTypes);
            $list["ArrayAccess not contains $label"] = $this->makeIncorrectItem($arrayAccessValue, $value);
        }

        foreach ($valueTypesComparison as $label => $value) {
            $iteratorValue = $this->makeIteratorObject($valueTypes);
            $list["Iterator not contains $label"] = $this->makeIncorrectItem($iteratorValue, $value);
        }

        foreach ($valueTypesComparison as $label => $value) {
            $iteratorAggrValue = $this->makeIteratorAggregateObject($valueTypes);
            $list["IteratorAggregate not contains $label"] = $this->makeIncorrectItem($iteratorAggrValue, $value);
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotContainsNeedle(mixed $value, mixed $needle): void
    {
        $assertion = new Contains($value, $needle);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), "Value must contain $needle");
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueNotContainsNeedle(mixed $value, mixed $needle): void
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
        mixed $needle,
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
        mixed $needle,
        string $message
    ): void {
        $assertion = new Contains($value, $needle);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
