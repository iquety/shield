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
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @return array<string,array<int,mixed>>
     */
    public function invalidProvider(): array
    {
        $list = [];

        $list['string contains @Co'] = $this->makeIncorrectItem('@Coração!#', '@Co');
        $list['string contains ra'] = $this->makeIncorrectItem('@Coração!#', 'ra');
        $list['string contains ção!#'] = $this->makeIncorrectItem('@Coração!#', 'ção!#');

        $list['stringable Exception  @Coração!# contains @Co']
            = $this->makeIncorrectItem(new Exception('@Coração!#'), '@Co');

        $list['stringable Exception  @Coração!# contains ra']
            = $this->makeIncorrectItem(new Exception('@Coração!#'), 'ra');

        $list['stringable Exception  @Coração!# contains ção!#']
            = $this->makeIncorrectItem(new Exception('@Coração!#'), 'ção!#');

        $list['stringable @Coração!# contains @Co']
            = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), '@Co');

        $list['stringable @Coração!# contains ra']
            = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), 'ra');

        $list['stringable @Coração!# contains ção!#']
            = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), 'ção!#');

        $list['string 12345.0 contains string 45.0']   = $this->makeIncorrectItem('12345.0', '45.0');
        $list['decimal 12345.0 contains string 45.0']  = $this->makeIncorrectItem(12345.0, '45.0');
        $list['string 12345.0 contains decimal 45.0']  = $this->makeIncorrectItem('12345.0', 45.0);
        $list['decimal 12345.0 contains decimal 45.0'] = $this->makeIncorrectItem(12345.0, 45.0);

        $list['boolean true contains boolean true'] = $this->makeIncorrectItem(true, true);
        $list['boolean true contains lower true']   = $this->makeIncorrectItem(true, 'true');
        $list['boolean true contains lower tr']     = $this->makeIncorrectItem(true, 'tr');
        $list['boolean true contains lower ue']     = $this->makeIncorrectItem(true, 'ue');
        $list['string true contains lower true']    = $this->makeIncorrectItem('true', 'true');
        $list['string true contains lower tr']      = $this->makeIncorrectItem('true', 'tr');
        $list['string true contains lower ue']      = $this->makeIncorrectItem('true', 'ue');

        $list['boolean true contains upper TRUE']   = $this->makeIncorrectItem(true, 'TRUE');
        $list['boolean true contains upper TR']     = $this->makeIncorrectItem(true, 'TR');
        $list['boolean true contains upper UE']     = $this->makeIncorrectItem(true, 'UE');
        $list['string TRUE contains upper TRUE']    = $this->makeIncorrectItem('TRUE', 'TRUE');
        $list['string TRUE contains upper TR']      = $this->makeIncorrectItem('TRUE', 'TR');
        $list['string TRUE contains upper UE']      = $this->makeIncorrectItem('TRUE', 'UE');

        $list['boolean false contains lower false'] = $this->makeIncorrectItem(false, 'false');
        $list['boolean false contains lower fa']    = $this->makeIncorrectItem(false, 'fa');
        $list['boolean false contains lower se']    = $this->makeIncorrectItem(false, 'se');
        $list['string false contains lower false']  = $this->makeIncorrectItem('false', 'false');
        $list['string false contains lower fa']     = $this->makeIncorrectItem('false', 'fa');
        $list['string false contains lower se']     = $this->makeIncorrectItem('false', 'se');

        $list['boolean false contains upper FALSE'] = $this->makeIncorrectItem(false, 'FALSE');
        $list['boolean false contains upper FA']    = $this->makeIncorrectItem(false, 'FA');
        $list['boolean false contains upper SE']    = $this->makeIncorrectItem(false, 'SE');
        $list['string false contains upper FALSE']  = $this->makeIncorrectItem('FALSE', 'FALSE');
        $list['string false contains upper FA']     = $this->makeIncorrectItem('FALSE', 'FA');
        $list['string false contains upper SE']     = $this->makeIncorrectItem('FALSE', 'SE');

        $list['null contains null']               = $this->makeIncorrectItem(null, null);
        $list['string null contains string null'] = $this->makeIncorrectItem('null', 'null');

        $list['null contains lower nu']          = $this->makeIncorrectItem(null, 'nu');
        $list['null contains lower ll']          = $this->makeIncorrectItem(null, 'll');
        $list['null contains lower null']        = $this->makeIncorrectItem(null, 'null');
        $list['string null contains lower nu']   = $this->makeIncorrectItem('null', 'nu');
        $list['string null contains lower ll']   = $this->makeIncorrectItem('null', 'll');
        $list['string null contains lower null'] = $this->makeIncorrectItem('null', 'null');

        $list['null contains upper NU']          = $this->makeIncorrectItem(null, 'NU');
        $list['null contains upper LL']          = $this->makeIncorrectItem(null, 'LL');
        $list['null contains upper NULL']        = $this->makeIncorrectItem(null, 'NULL');
        $list['string null contains upper NU']   = $this->makeIncorrectItem('NULL', 'NU');
        $list['string null contains upper LL']   = $this->makeIncorrectItem('NULL', 'LL');
        $list['string null contains upper NULL'] = $this->makeIncorrectItem('NULL', 'NULL');

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
