<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayAccess;
use ArrayIterator;
use ArrayObject;
use Exception;
use Iquety\Shield\Assertion\NotContains;
use stdClass;
use Stringable;

class NotContainsTest extends AssertionSearchCase
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

        $list['stringable Exception @Coração!# contains $']   = [new Exception('@Coração!#'), '$'];
        $list['stringable Exception @Coração!# contains @Cr'] = [new Exception('@Coração!#'), '@Cr'];

        $list['stringable @Coração!# contains $']   = [$this->makeStringableObject('@Coração!#'), '$'];
        $list['stringable @Coração!# contains @Cr'] = [$this->makeStringableObject('@Coração!#'), '@Cr'];

        $list['object not valid'] = [new stdClass(), ''];
        $list['null not valid']   = [null, ''];
        $list['true not valid']   = [true, ''];
        $list['false not valid']  = [false, ''];

        $valueTypes = $this->makeValueTypeList();

        $valueTypesComparison = $this->makeValueComparisonList();

        foreach ($valueTypesComparison as $label => $value) {
            $list["array not contains $label"] = [
                $valueTypes,
                $value
            ];
        }

        foreach ($valueTypesComparison as $label => $value) {
            $label = $this->makeStdProperty($label);

            $list["stdClass not contains value of property $label"] = [
                $valueTypes,
                $value
            ];
        }

        foreach ($valueTypesComparison as $label => $value) {
            $list["ArrayAccess not contains $label"] = [
                $valueTypes,
                $value
            ];
        }

        foreach ($valueTypesComparison as $label => $value) {
            $list["IteratorAggregate not contains $label"] = [
                new ArrayObject($valueTypes),
                $value
            ];
        }

        foreach ($valueTypesComparison as $label => $value) {
            $list["Iterator not contains $label"] = [
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
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @return array<string,array<int,mixed>>
     */
    public function invalidProvider(): array
    {
        $list = [];

        $list['string contains @Co'] = $this->makeIncorrectItem('@Coração!#', '@Co');
        $list['string contains ra'] = $this->makeIncorrectItem('@Coração!#', 'ra');
        $list['string contains ção!#'] = $this->makeIncorrectItem('@Coração!#', 'ção!#');

        $list['stringable Exception  @Coração!# contains @Co']   = $this->makeIncorrectItem(new Exception('@Coração!#'), '@Co');
        $list['stringable Exception  @Coração!# contains ra']    = $this->makeIncorrectItem(new Exception('@Coração!#'), 'ra');
        $list['stringable Exception  @Coração!# contains ção!#'] = $this->makeIncorrectItem(new Exception('@Coração!#'), 'ção!#');

        $list['stringable @Coração!# contains @Co']   = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), '@Co');
        $list['stringable @Coração!# contains ra']    = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), 'ra');
        $list['stringable @Coração!# contains ção!#'] = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), 'ção!#');

        $valueTypes = $this->makeValueTypeList();

        foreach ($valueTypes as $label => $value) {
            $list["array contains $label"] = $this->makeIncorrectItem($valueTypes, $value);
        }

        foreach ($valueTypes as $label => $value) {
            $label = $this->makeStdProperty($label);

            $list["stdClass contains value of property $label"] = $this->makeIncorrectItem($valueTypes, $value);
        }

        foreach ($valueTypes as $label => $value) {
            $list["ArrayAccess contains $label"] = $this->makeIncorrectItem($valueTypes, $value);
        }

        foreach ($valueTypes as $label => $value) {
            $list["IteratorAggregate contains $label"] = $this->makeIncorrectItem(
                new ArrayObject($valueTypes),
                $value
            );
        }

        foreach ($valueTypes as $label => $value) {
            $list["Iterator contains $label"] = $this->makeIncorrectItem(
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
