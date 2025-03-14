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

    /** @return array<string,array<int,mixed>> */
    public function invalidProvider(): array
    {
        $list = [];

        $list['string not start with $']   = $this->makeIncorrectItem('@Coração!#', '$');
        $list['string not start with @Cr'] = $this->makeIncorrectItem('@Coração!#', '@Cr');
        $list['object not valid']          = $this->makeIncorrectItem(new stdClass(), '');
        $list['null not valid']            = $this->makeIncorrectItem(null, '');
        $list['true not valid']            = $this->makeIncorrectItem(true, '');
        $list['false not valid']           = $this->makeIncorrectItem(false, '');

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
