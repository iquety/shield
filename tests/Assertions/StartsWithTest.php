<?php

declare(strict_types=1);

namespace Tests\Assertions;

use InvalidArgumentException;
use Iquety\Shield\Assertion\StartsWith;
use stdClass;

/** @SuppressWarnings(PHPMD.TooManyPublicMethods) */
class StartsWithTest extends AssertionSearchCase
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

        $assertion = new StartsWith($value, 'string');

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

        $assertion = new StartsWith('string', $needle);

        $assertion->isValid();
    }

    /** @test */
    public function needleForListIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Null is not a valid search value for a list');

        $assertion = new StartsWith(['x'], null);

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

        $list['string @Coração!# starts with @Cor']     = ['@Coração!#', '@Cor'];
        $list['string 123456 starts with 123']           = ['123456', '123'];
        $list['stringable @Coração!# starts with @Cor'] = [$this->makeStringableObject('@Coração!#'), '@Cor'];

        $valueTypes = $this->makeValueTypeList();
        $firstValue = $valueTypes[array_key_first($valueTypes)];

        foreach (array_keys($valueTypes) as $label) {
            $list["array starts with $label"] = [$valueTypes, $firstValue];
        }

        foreach (array_keys($valueTypes) as $label) {
            $label = $this->makeStdProperty($label);
            $stdClassValue = $this->makeStdObject($valueTypes);
            $list["stdClass starts with value of property $label"] = [$stdClassValue, $firstValue];
        }

        foreach (array_keys($valueTypes) as $label) {
            $arrayAccessValue = $this->makeArrayAccessObject($valueTypes);
            $list["ArrayAccess starts with $label"] = [$arrayAccessValue, $firstValue];
        }

        foreach (array_keys($valueTypes) as $label) {
            $iteratorValue = $this->makeIteratorObject($valueTypes);
            $list["Iterator starts with $label"] = [$iteratorValue, $firstValue];
        }

        foreach (array_keys($valueTypes) as $label) {
            $iteratorAggrValue = $this->makeIteratorAggregateObject($valueTypes);
            $list["IteratorAggregate starts with $label"] = [$iteratorAggrValue, $firstValue];
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueStartsWithPartial(mixed $value, mixed $needle): void
    {
        $assertion = new StartsWith($value, $needle);

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

        $list['string @Coração!# not starts with $']     = $this->makeIncorrectItem('@Coração!#', '$');
        $list['stringable @Coração!# not starts with $'] = $this->makeIncorrectItem($stringable, '$');

        $valueTypes = $this->makeValueTypeList();

        $valueTypesComparison = $this->makeValueComparisonList();

        foreach ($valueTypesComparison as $label => $value) {
            $list["array not starts with $label"] = $this->makeIncorrectItem($valueTypes, $value);
        }

        foreach ($valueTypesComparison as $label => $value) {
            $label = sprintf(
                "stdClass not starts with value of property %s",
                $this->makeStdProperty($label)
            );

            $stdClassValue = $this->makeStdObject($valueTypes);

            $list[$label] = $this->makeIncorrectItem($stdClassValue, $value);
        }

        foreach ($valueTypesComparison as $label => $value) {
            $arrayAccessValue = $this->makeArrayAccessObject($valueTypes);
            $list["ArrayAccess not starts with $label"] = $this->makeIncorrectItem($arrayAccessValue, $value);
        }

        foreach ($valueTypesComparison as $label => $value) {
            $iteratorValue = $this->makeIteratorObject($valueTypes);
            $list["Iterator not starts with $label"] = $this->makeIncorrectItem($iteratorValue, $value);
        }

        foreach ($valueTypesComparison as $label => $value) {
            $iteratorAggrValue = $this->makeIteratorAggregateObject($valueTypes);
            $list["IteratorAggregate not starts with $label"] = $this->makeIncorrectItem($iteratorAggrValue, $value);
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotStartsWithPartial(mixed $value, mixed $needle): void
    {
        $assertion = new StartsWith($value, $needle);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), "Value must start with '$needle'");
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueNotStartsWithPartial(mixed $value, mixed $needle): void
    {
        $assertion = new StartsWith($value, $needle);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must start with '$needle'"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueNotStartsWithPartialAndCustomMessage(
        mixed $value,
        mixed $needle,
        string $message
    ): void {
        $assertion = new StartsWith($value, $needle);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotStartsWithPartialAndCustomMessage(
        mixed $value,
        mixed $needle,
        string $message
    ): void {
        $assertion = new StartsWith($value, $needle);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
