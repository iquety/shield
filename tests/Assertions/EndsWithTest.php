<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
use ArrayObject;
use Iquety\Shield\Assertion\EndsWith;

class EndsWithTest extends AssertionSearchCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['string ends with !#'] = ['@Coração!#', '!#'];

        $list['stringable @Coração!# ends with o!#'] = [
            $this->makeStringableObject('@Coração!#'),
            'o!#'
        ];

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
        $list['null not valid']          = $this->makeIncorrectItem(null, '');
        $list['true not valid']          = $this->makeIncorrectItem(true, '');
        $list['false not valid']         = $this->makeIncorrectItem(false, '');

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
