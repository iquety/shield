<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
use ArrayObject;
use Exception;
use Iquety\Shield\Assertion\Contains;
use stdClass;
use Stringable;

class ContainsTest extends AssertionSearchCase
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

        $list['stringable Exception  @Coração!# contains @Co']   = [new Exception('@Coração!#'), '@Co'];
        $list['stringable Exception  @Coração!# contains ra']    = [new Exception('@Coração!#'), 'ra'];
        $list['stringable Exception  @Coração!# contains ção!#'] = [new Exception('@Coração!#'), 'ção!#'];

        $list['stringable @Coração!# contains @Co']   = [$this->makeStringableObject('@Coração!#'), '@Co'];
        $list['stringable @Coração!# contains ra']    = [$this->makeStringableObject('@Coração!#'), 'ra'];
        $list['stringable @Coração!# contains ção!#'] = [$this->makeStringableObject('@Coração!#'), 'ção!#'];

        $valueTypes = $this->makeValueTypeList();

        foreach ($valueTypes as $label => $value) {
            $list["array contains $label"] = [$valueTypes, $value];
        }

        foreach ($valueTypes as $label => $value) {
            $label = $this->makeStdProperty($label);

            $list["stdClass contains value of property $label"] = [$valueTypes, $value];
        }

        foreach ($valueTypes as $label => $value) {
            $list["ArrayAccess contains $label"] = [$valueTypes, $value];
        }

        foreach ($valueTypes as $label => $value) {
            $list["IteratorAggregate contains $label"] = [
                new ArrayObject($valueTypes),
                $value
            ];
        }

        foreach ($valueTypes as $label => $value) {
            $list["Iterator contains $label"] = [
                new ArrayIterator($valueTypes),
                $value
            ];
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

        $list['string @Coração!# not contains $']   = $this->makeIncorrectItem('@Coração!#', '$');
        $list['string @Coração!# not contains @Cr'] = $this->makeIncorrectItem('@Coração!#', '@Cr');

        $list['stringable Exception @Coração!# contains $']
            = $this->makeIncorrectItem(new Exception('@Coração!#'), '$');

        $list['stringable Exception @Coração!# contains @Cr']
            = $this->makeIncorrectItem(new Exception('@Coração!#'), '@Cr');

        $list['stringable @Coração!# contains $']
            = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), '$');

        $list['stringable @Coração!# contains @Cr']
            = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), '@Cr');

        $list['object not valid'] = $this->makeIncorrectItem(new stdClass(), '');
        $list['null not valid']   = $this->makeIncorrectItem(null, '');
        $list['true not valid']   = $this->makeIncorrectItem(true, '');
        $list['false not valid']  = $this->makeIncorrectItem(false, '');

        $valueTypes = $this->makeValueTypeList();

        $valueTypesComparison = $this->makeValueComparisonList();

        foreach ($valueTypesComparison as $label => $value) {
            $list["array not contains $label"] = $this->makeIncorrectItem(
                $valueTypes,
                $value
            );
        }

        foreach ($valueTypesComparison as $label => $value) {
            $label = $this->makeStdProperty($label);

            $list["stdClass not contains value of property $label"] = $this->makeIncorrectItem(
                $valueTypes,
                $value
            );
        }

        foreach ($valueTypesComparison as $label => $value) {
            $list["ArrayAccess not contains $label"] = $this->makeIncorrectItem(
                $valueTypes,
                $value
            );
        }

        foreach ($valueTypesComparison as $label => $value) {
            $list["IteratorAggregate not contains $label"] = $this->makeIncorrectItem(
                new ArrayObject($valueTypes),
                $value
            );
        }

        foreach ($valueTypesComparison as $label => $value) {
            $list["Iterator not contains $label"] = $this->makeIncorrectItem(
                new ArrayIterator($valueTypes),
                $value
            );
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
