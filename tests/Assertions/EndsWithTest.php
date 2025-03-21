<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
use ArrayObject;
use Iquety\Shield\Assertion\EndsWith;

class EndsWithTest extends AssertionSearchCase
{
    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @return array<string,array<int,mixed>>
     */
    public function validProvider(): array
    {
        $list = [];

        $list['string ends with !#'] = ['@Coração!#', '!#'];

        $list['string 123456 ends with string 456']   = ['123456', '456'];
        $list['string 123456 ends with integer 456']  = ['123456', 456];
        $list['integer 123456 ends with string 456']  = [123456, '456'];
        $list['integer 123456 ends with integer 456'] = [123456, 456];

        $list['string 12345.6 ends with string 45.6']   = ['12345.6', '45.6'];
        $list['string 12345.6 ends with decimal 45.6']  = ['12345.6', 45.6];
        $list['decimal 12345.6 ends with string 45.6']  = [12345.6, '45.6'];
        $list['decimal 12345.6 ends with decimal 45.6'] = [12345.6, 45.6];

        $list['stringable @Coração!# ends with o!#'] = [
            $this->makeStringableObject('@Coração!#'),
            'o!#'
        ];

        $list['boolean true ends with boolean true']   = [true, true];
        $list['boolean true ends with lower true']   = [true, 'true'];
        $list['boolean true ends with lower ue']     = [true, 'ue'];
        $list['string true ends with lower true']    = ['true', 'true'];
        $list['string true ends with lower ue']      = ['true', 'ue'];

        $list['boolean true ends with upper TRUE']   = [true, 'TRUE'];
        $list['boolean true ends with upper UE']     = [true, 'UE'];
        $list['string TRUE ends with upper TRUE']    = ['TRUE', 'TRUE'];
        $list['string TRUE ends with upper UE']      = ['TRUE', 'UE'];

        $list['boolean false ends with lower false'] = [false, 'false'];
        $list['boolean false ends with lower se']    = [false, 'se'];
        $list['string false ends with lower false']  = ['false', 'false'];
        $list['string false ends with lower se']     = ['false', 'se'];

        $list['boolean false ends with upper FALSE'] = [false, 'FALSE'];
        $list['boolean false ends with upper SE']    = [false, 'SE'];
        $list['string false ends with upper FALSE']  = ['FALSE', 'FALSE'];
        $list['string false ends with upper SE']     = ['FALSE', 'SE'];

        $list['null ends with null']              = [null, null];
        $list['null ends with lower ll']          = [null, 'll'];
        $list['null ends with lower null']        = [null, 'null'];
        $list['string null ends with lower null'] = ['null', 'null'];
        $list['string null ends with lower ll']   = ['null', 'll'];
        $list['string null ends with lower null'] = ['null', 'null'];

        $list['null ends with upper LL']          = [null, 'LL'];
        $list['null ends with upper NULL']        = [null, 'NULL'];
        $list['string null ends with upper NULL'] = ['NULL', 'NULL'];
        $list['string null ends with upper LL']   = ['NULL', 'LL'];
        $list['string null ends with upper NULL'] = ['NULL', 'NULL'];

        // lista de valores de diversos tipos
        $valueTypes = $this->makeValueTypeList();

        $arrayValues = $valueTypes;
        foreach (array_keys($valueTypes) as $label) {
            $list["array ends with $label"] = [
                $arrayValues,
                $this->popArrayValue($arrayValues)
            ];
        }

        $stdValues = $valueTypes;
        foreach (array_keys($stdValues) as $label) {
            $label = $this->makeStdProperty($label);

            $list["stdClass ends with value of property $label"] = [
                $stdValues,
                $this->popStdValue($stdValues)
            ];
        }

        $arrayAccessValues = $valueTypes;
        foreach (array_keys($valueTypes) as $label) {
            $list["ArrayAccess ends with $label"] = [
                $arrayAccessValues,
                $this->popArrayAccessValue($arrayAccessValues)
            ];
        }

        $iteratorAggrValues = $valueTypes;
        foreach (array_keys($valueTypes) as $label) {
            $list["IteratorAggregate ends with $label"] = [
                new ArrayObject($iteratorAggrValues),
                $this->popIteratorAggrValue($iteratorAggrValues)
            ];
        }

        $iteratorValues = $valueTypes;
        foreach (array_keys($valueTypes) as $label) {
            $list["Iterator ends with $label"] = [
                new ArrayIterator($iteratorValues),
                $this->popIteratorValue($iteratorValues)
            ];
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

        $list['string not end with $']   = $this->makeIncorrectItem('@Coração!#', '$');
        $list['string not end with @Cr'] = $this->makeIncorrectItem('@Coração!#', '@Cr');

        $list['boolean true not ends with lower tr']   = $this->makeIncorrectItem(true, 'tr');
        $list['boolean false not ends with lower fal'] = $this->makeIncorrectItem(false, 'fal');
        $list['string true not ends with lower tr']    = $this->makeIncorrectItem('true', 'tr');
        $list['string false not ends with lower fal']  = $this->makeIncorrectItem('false', 'fal');

        $list['boolean true not ends with upper TR']   = $this->makeIncorrectItem(true, 'TR');
        $list['boolean false not ends with upper FAL'] = $this->makeIncorrectItem(false, 'FAL');
        $list['string TRUE not ends with upper TR']    = $this->makeIncorrectItem('TRUE', 'TR');
        $list['string FALSE not ends with upper FAL']  = $this->makeIncorrectItem('TRUE', 'FAL');

        $list['null not ends with lower nu']   = $this->makeIncorrectItem(null, 'nu');
        $list['string null not ends with lower nu']   = $this->makeIncorrectItem('null', 'nu');

        $list['null not ends with upper NU']   = $this->makeIncorrectItem(null, 'NU');
        $list['string NULL not ends with upper NU']   = $this->makeIncorrectItem('NULL', 'NU');

        $valueTypes = $this->makeValueTypeList();

        $valueTypesComparison = $this->makeValueComparisonList();

        $arrayValues = $valueTypes;
        $arrayComparison = $valueTypesComparison;
        foreach (array_keys($valueTypes) as $label) {
            $list["array not ends with $label"] = $this->makeIncorrectItem(
                $arrayValues,
                $this->popArrayValue($arrayComparison)
            );
        }

        $stdValues = $valueTypes;
        $stdComparison = $valueTypesComparison;
        foreach (array_keys($stdValues) as $label) {
            $label = $this->makeStdProperty($label);

            $list["stdClass not ends with value of property $label"] = $this->makeIncorrectItem(
                $stdValues,
                $this->popStdValue($stdComparison)
            );
        }

        $arrayAccessValues = $valueTypes;
        $arrayAccessComparison = $valueTypesComparison;
        foreach (array_keys($valueTypes) as $label) {
            $list["ArrayAccess not ends with $label"] = $this->makeIncorrectItem(
                $arrayAccessValues,
                $this->popArrayAccessValue($arrayAccessComparison)
            );
        }

        $iteratorAggrValues = $valueTypes;
        $iteratorAggrComparison = $valueTypesComparison;
        foreach (array_keys($valueTypes) as $label) {
            $list["IteratorAggregate not ends with $label"] = $this->makeIncorrectItem(
                new ArrayObject($iteratorAggrValues),
                $this->popIteratorAggrValue($iteratorAggrComparison)
            );
        }

        $iteratorValues = $valueTypes;
        $iteratorComparison = $valueTypesComparison;
        foreach (array_keys($valueTypes) as $label) {
            $list["Iterator not ends with $label"] = $this->makeIncorrectItem(
                new ArrayIterator($iteratorValues),
                $this->popIteratorValue($iteratorComparison)
            );
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
