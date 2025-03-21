<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
use ArrayObject;
use Iquety\Shield\Assertion\StartsWith;
use stdClass;

class StartsWithTest extends AssertionSearchCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['string starts with @'] = ['@Coração!#', '@Co'];

        $list['string 123456 starts with string 123']   = ['123456', '123'];
        $list['string 123456 starts with integer 123']  = ['123456', 123];
        $list['integer 123456 starts with string 123']  = [123456, '123'];
        $list['integer 123456 starts with integer 123'] = [123456, 123];

        $list['string 12.0 starts with string 12.0']   = ['12.0', '12.0'];
        $list['decimal 12.0 starts with string 12.0']  = [12.0, '12.0'];
        $list['string 12.0 starts with decimal 12.0']  = ['12.0', 12.0];
        $list['decimal 12.0 starts with decimal 12.0'] = [12.0, 12.0];

        $list['string 12345.6 starts with string 123']   = ['12345.6', '123'];
        $list['string 12345.6 starts with decimal 123']  = ['12345.6', 123];
        $list['decimal 12345.6 starts with string 123']  = [12345.6, '123'];
        $list['decimal 12345.6 starts with decimal 123'] = [12345.6, 123];

        $list['boolean true starts with boolean true']   = [true, true];
        $list['boolean true starts with lower true']   = [true, 'true'];
        $list['boolean true starts with lower tr']     = [true, 'tr'];
        $list['string true starts with lower true']    = ['true', 'true'];
        $list['string true starts with lower tr']      = ['true', 'tr'];

        $list['boolean true starts with upper TRUE']   = [true, 'TRUE'];
        $list['boolean true starts with upper TR']     = [true, 'TR'];
        $list['string TRUE starts with upper TRUE']    = ['TRUE', 'TRUE'];
        $list['string TRUE starts with upper TR']      = ['TRUE', 'TR'];

        $list['boolean false starts with lower false'] = [false, 'false'];
        $list['boolean false starts with lower fa']    = [false, 'fa'];
        $list['string false starts with lower false']  = ['false', 'false'];
        $list['string false starts with lower fa']     = ['false', 'fa'];

        $list['boolean false starts with upper FALSE'] = [false, 'FALSE'];
        $list['boolean false starts with upper FA']    = [false, 'FA'];
        $list['string false starts with upper FALSE']  = ['FALSE', 'FALSE'];
        $list['string false starts with upper FA']     = ['FALSE', 'FA'];

        $list['null starts with null']              = [null, null];
        $list['null starts with lower nu']          = [null, 'nu'];
        $list['null starts with lower null']        = [null, 'null'];
        $list['string null starts with lower null'] = ['null', 'null'];
        $list['string null starts with lower nu']   = ['null', 'nu'];
        $list['string null starts with lower null'] = ['null', 'null'];

        $list['null starts with upper NU']          = [null, 'NU'];
        $list['null starts with upper NULL']        = [null, 'NULL'];
        $list['string null starts with upper NULL'] = ['NULL', 'NULL'];
        $list['string null starts with upper NU']   = ['NULL', 'NU'];
        $list['string null starts with upper NULL'] = ['NULL', 'NULL'];

        $list['stringable @Coração!# starts with @Cor'] = [
            $this->makeStringableObject('@Coração!#'),
            '@Cor'
        ];

        $valueTypes = $this->makeValueTypeList();

        $arrayValues = $valueTypes;
        foreach (array_keys($valueTypes) as $label) {
            $list["array starts with $label"] = [
                $arrayValues,
                $this->shiftArrayValue($arrayValues)
            ];
        }

        $stdValues = $valueTypes;
        foreach (array_keys($stdValues) as $label) {
            $label = $this->makeStdProperty($label);

            $list["stdClass starts with value of property $label"] = [
                $stdValues,
                $this->shiftStdValue($stdValues)
            ];
        }

        $arrayAccessValues = $valueTypes;
        foreach (array_keys($valueTypes) as $label) {
            $list["ArrayAccess starts with $label"] = [
                $arrayAccessValues,
                $this->shiftArrayAccessValue($arrayAccessValues)
            ];
        }

        $iteratorAggrValues = $valueTypes;
        foreach (array_keys($valueTypes) as $label) {
            $list["IteratorAggregate starts with $label"] = [
                new ArrayObject($iteratorAggrValues),
                $this->shiftIteratorAggrValue($iteratorAggrValues)
            ];
        }

        $iteratorValues = $valueTypes;
        foreach (array_keys($valueTypes) as $label) {
            $list["Iterator starts with $label"] = [
                new ArrayIterator($iteratorValues),
                $this->shiftIteratorValue($iteratorValues)
            ];
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

        $list['string not start with $']   = $this->makeIncorrectItem('@Coração!#', '$');
        $list['string not start with @Cr'] = $this->makeIncorrectItem('@Coração!#', '@Cr');
        $list['object not valid']          = $this->makeIncorrectItem(new stdClass(), '');

        $list['boolean true not starts with lower ue']  = $this->makeIncorrectItem(true, 'ue');
        $list['boolean false not starts with lower se'] = $this->makeIncorrectItem(false, 'se');
        $list['string true not starts with lower ue']   = $this->makeIncorrectItem('true', 'ue');
        $list['string false not starts with lower se']  = $this->makeIncorrectItem('false', 'se');

        $list['boolean true not starts with upper UE']  = $this->makeIncorrectItem(true, 'UE');
        $list['boolean false not starts with upper SE'] = $this->makeIncorrectItem(false, 'SE');
        $list['string TRUE not starts with upper UE']   = $this->makeIncorrectItem('TRUE', 'UE');
        $list['string FALSE not starts with upper SE']  = $this->makeIncorrectItem('FALSE', 'SE');

        $list['null not starts with lower ll']        = $this->makeIncorrectItem(null, 'll');
        $list['null not starts with upper LL']        = $this->makeIncorrectItem(null, 'LL');

        $list['string NULL not starts with lower ll'] = $this->makeIncorrectItem('NULL', 'll');
        $list['string NULL not starts with upper LL'] = $this->makeIncorrectItem('NULL', 'LL');


        $valueTypes = $this->makeValueTypeList();

        $valueTypesComparison = $this->makeValueComparisonList();

        $arrayValues = $valueTypes;
        $arrayComparison = $valueTypesComparison;
        foreach (array_keys($valueTypes) as $label) {
            $list["array not starts with $label"] = $this->makeIncorrectItem(
                $arrayValues,
                $this->shiftArrayValue($arrayComparison)
            );
        }

        $stdValues = $valueTypes;
        $stdComparison = $valueTypesComparison;
        foreach (array_keys($stdValues) as $label) {
            $label = $this->makeStdProperty($label);

            $list["stdClass not starts with value of property $label"] = $this->makeIncorrectItem(
                $stdValues,
                $this->shiftStdValue($stdComparison)
            );
        }

        $arrayAccessValues = $valueTypes;
        $arrayAccessComparison = $valueTypesComparison;
        foreach (array_keys($valueTypes) as $label) {
            $list["ArrayAccess not starts with $label"] = $this->makeIncorrectItem(
                $arrayAccessValues,
                $this->shiftArrayAccessValue($arrayAccessComparison)
            );
        }

        $iteratorAggrValues = $valueTypes;
        $iteratorAggrComparison = $valueTypesComparison;
        foreach (array_keys($valueTypes) as $label) {
            $list["IteratorAggregate not starts with $label"] = $this->makeIncorrectItem(
                new ArrayObject($iteratorAggrValues),
                $this->shiftIteratorAggrValue($iteratorAggrComparison)
            );
        }

        $iteratorValues = $valueTypes;
        $iteratorComparison = $valueTypesComparison;
        foreach (array_keys($valueTypes) as $label) {
            $list["Iterator not starts with $label"] = $this->makeIncorrectItem(
                new ArrayIterator($iteratorValues),
                $this->shiftIteratorValue($iteratorComparison)
            );
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
