<?php

declare(strict_types=1);

namespace Tests\Assertions;

use InvalidArgumentException;
use Iquety\Shield\Assertion\EndsWith;
use stdClass;

/** @SuppressWarnings(PHPMD.TooManyPublicMethods) */
class EndsWithTest extends AssertionSearchCase
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

        $assertion = new EndsWith($value, 'string');

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

        $assertion = new EndsWith('string', $needle);

        $assertion->isValid();
    }

    /** @test */
    public function needleForListIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Null is not a valid search value for a list');

        $assertion = new EndsWith(['x'], null);

        $assertion->isValid();
    }

    /**
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

        $list['string @Coração!# ends with ção!#']     = ['@Coração!#', 'ção!#'];
        $list['string 123456 ends with 456']           = ['123456', '456'];
        $list['stringable @Coração!# ends with ção!#'] = [$this->makeStringableObject('@Coração!#'), 'ção!#'];

        $valueTypes = $this->makeValueTypeList();
        $lastValue = $valueTypes[array_key_last($valueTypes)];

        foreach (array_keys($valueTypes) as $label) {
            $list["array ends with $label"] = [$valueTypes, $lastValue];
        }

        foreach (array_keys($valueTypes) as $label) {
            $label = $this->makeStdProperty($label);
            $stdClassValue = $this->makeStdObject($valueTypes);
            $list["stdClass ends with value of property $label"] = [$stdClassValue, $lastValue];
        }

        foreach (array_keys($valueTypes) as $label) {
            $arrayAccessValue = $this->makeArrayAccessObject($valueTypes);
            $list["ArrayAccess ends with $label"] = [$arrayAccessValue, $lastValue];
        }

        foreach (array_keys($valueTypes) as $label) {
            $iteratorValue = $this->makeIteratorObject($valueTypes);
            $list["Iterator ends with $label"] = [$iteratorValue, $lastValue];
        }

        foreach (array_keys($valueTypes) as $label) {
            $iteratorAggrValue = $this->makeIteratorAggregateObject($valueTypes);
            $list["IteratorAggregate ends with $label"] = [$iteratorAggrValue, $lastValue];
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueEndsWithPartial(mixed $value, mixed $needle): void
    {
        $assertion = new EndsWith($value, $needle);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value, mixed $needle): array
    {
        $messageValue = $this->makeMessageValue($value);

        return [
            $value,
            $needle,
            "O valor $messageValue está errado" // mensagem personalizada
        ];
    }

    /**
     * @SuppressWarnings("PHPMD.LongVariable")
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

        $list['string @Coração!# not ends with $']     = $this->makeIncorrectItem('@Coração!#', '$');
        $list['stringable @Coração!# not ends with $'] = $this->makeIncorrectItem($stringable, '$');

        $valueTypes = $this->makeValueTypeList();

        $valueTypesComparison = $this->makeValueComparisonList();

        foreach ($valueTypesComparison as $label => $value) {
            $list["array not ends with $label"] = $this->makeIncorrectItem($valueTypes, $value);
        }

        foreach ($valueTypesComparison as $label => $value) {
            $label = $this->makeStdProperty($label);
            $stdClassValue = $this->makeStdObject($valueTypes);
            $list["stdClass not ends with value of property $label"] = $this->makeIncorrectItem($stdClassValue, $value);
        }

        foreach ($valueTypesComparison as $label => $value) {
            $arrayAccessValue = $this->makeArrayAccessObject($valueTypes);
            $list["ArrayAccess not ends with $label"] = $this->makeIncorrectItem($arrayAccessValue, $value);
        }

        foreach ($valueTypesComparison as $label => $value) {
            $iteratorValue = $this->makeIteratorObject($valueTypes);
            $list["Iterator not ends with $label"] = $this->makeIncorrectItem($iteratorValue, $value);
        }

        foreach ($valueTypesComparison as $label => $value) {
            $iteratorAggrValue = $this->makeIteratorAggregateObject($valueTypes);
            $list["IteratorAggregate not ends with $label"] = $this->makeIncorrectItem($iteratorAggrValue, $value);
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotEndsWithPartial(mixed $value, mixed $needle): void
    {
        $assertion = new EndsWith($value, $needle);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), "Value must end with '$needle'");
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueNotEndsWithPartial(mixed $value, mixed $needle): void
    {
        $assertion = new EndsWith($value, $needle);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must end with '$needle'"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueNotEndsWithPartialWithCustomMessage(
        mixed $value,
        mixed $needle,
        string $message
    ): void {
        $assertion = new EndsWith($value, $needle);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotEndsWithPartialAndCustomMessage(
        mixed $value,
        mixed $needle,
        string $message
    ): void {
        $assertion = new EndsWith($value, $needle);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
