<?php

declare(strict_types=1);

namespace Tests\Assertions;

use InvalidArgumentException;
use Iquety\Shield\Assertion\NotContains;
use stdClass;
use Stringable;

/** @SuppressWarnings(PHPMD.TooManyPublicMethods) */
class NotContainsTest extends AssertionSearchCase
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

        $assertion = new NotContains($value, 'string');

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

        $assertion = new NotContains('string', $needle);

        $assertion->isValid();
    }

    /** @test */
    public function needleForListIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Null is not a valid search value for a list');

        $assertion = new NotContains(['x'], null);

        $assertion->isValid();
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
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

        $stringable = $this->makeStringableObject('@Coração!#');

        $list['string @Coração!# not contains $']     = ['@Coração!#', '$'];
        $list['string @Coração!# not contains @Cr']   = ['@Coração!#', '@Cr'];
        $list['stringable @Coração!# not contains $'] = [$stringable, '$'];
        $list['stringable @Coração!# not contains $'] = [$stringable, '@Cr'];

        $valueTypes = $this->makeValueTypeList();

        $valueTypesComparison = $this->makeValueComparisonList();

        foreach ($valueTypesComparison as $label => $value) {
            $list["array not contains $label"] = [$valueTypes, $value];
        }

        foreach ($valueTypesComparison as $label => $value) {
            $label = $this->makeStdProperty($label);
            $stdClassValue = $this->makeStdObject($valueTypes);
            $list["stdClass not contains value of property $label"] = [$stdClassValue, $value];
        }

        foreach ($valueTypesComparison as $label => $value) {
            $arrayAccessValue = $this->makeArrayAccessObject($valueTypes);
            $list["ArrayAccess not contains $label"] = [$arrayAccessValue, $value];
        }

        foreach ($valueTypesComparison as $label => $value) {
            $iteratorValue = $this->makeIteratorObject($valueTypes);
            $list["Iterator not contains $label"] = [$iteratorValue, $value];
        }

        foreach ($valueTypesComparison as $label => $value) {
            $iteratorAggrValue = $this->makeIteratorAggregateObject($valueTypes);
            $list["IteratorAggregate not contains $label"] = [$iteratorAggrValue, $value];
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueNotContainsNeedle(mixed $value, mixed $needle): void
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
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
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

        $list['string @Coração!# contains @Co']       = $this->makeIncorrectItem('@Coração!#', '@Co');
        $list['string @Coração!# contains ra']        = $this->makeIncorrectItem('@Coração!#', 'ra');
        $list['string @Coração!# contains ção!#']     = $this->makeIncorrectItem('@Coração!#', 'ção!#');
        $list['string 123456 contains 123']           = $this->makeIncorrectItem('123456', '123');
        $list['string 123456 contains 345']           = $this->makeIncorrectItem('123456', '345');
        $list['string 123456 contains 456']           = $this->makeIncorrectItem('123456', '456');
        $list['stringable @Coração!# contains @Co']
            = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), '@Co');
        $list['stringable @Coração!# contains ra']
            = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), 'ra');
        $list['stringable @Coração!# contains ção!#']
            = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), 'ção!#');

        $valueTypes = $this->makeValueTypeList();

        foreach ($valueTypes as $label => $needle) {
            $list["array contains $label"] = $this->makeIncorrectItem($valueTypes, $needle);
        }

        foreach ($valueTypes as $label => $needle) {
            $label = $this->makeStdProperty($label);
            $stdClassValue = $this->makeStdObject($valueTypes);
            $list["stdClass contains value of property $label"] = $this->makeIncorrectItem($stdClassValue, $needle);
        }

        foreach ($valueTypes as $label => $needle) {
            $arrayAccessValue = $this->makeArrayAccessObject($valueTypes);
            $list["ArrayAccess contains $label"] = $this->makeIncorrectItem($arrayAccessValue, $needle);
        }

        foreach ($valueTypes as $label => $needle) {
            $iteratorValue = $this->makeIteratorObject($valueTypes);
            $list["Iterator contains $label"] = $this->makeIncorrectItem($iteratorValue, $needle);
        }

        foreach ($valueTypes as $label => $needle) {
            $iteratorAggrValue = $this->makeIteratorAggregateObject($valueTypes);
            $list["IteratorAggregate contains $label"] = $this->makeIncorrectItem($iteratorAggrValue, $needle);
        }


        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueContainsNeedle(mixed $value, mixed $needle): void
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
    public function namedValueContainsNeedle(mixed $value, mixed $needle): void
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
        mixed $needle,
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
        mixed $needle,
        string $message
    ): void {
        $assertion = new NotContains($value, $needle);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
