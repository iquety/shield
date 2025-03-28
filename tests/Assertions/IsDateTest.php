<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsDate;
use stdClass;

class IsDateTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['iso 8601']               = ['2024-12-31'];
        $list['european format']        = ['31/12/2024'];
        $list['us format']              = ['12/31/2024'];
        $list['alternative format']     = ['2024.12.31'];
        $list['abbreviated month name'] = ['31-Dec-2024'];
        $list['full month name']        = ['December 31, 2024'];
        $list['stringable']             = [$this->makeStringableObject('December 31, 2024')];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsDate(mixed $dateValue): void
    {
        $assertion = new IsDate($dateValue);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value): array
    {
        $messageValue = $this->makeMessageValue($value);

        return [
            $value,
            "O valor $messageValue está errado" // mensagem personalizada
        ];
    }

    /** @return array<string,array<int,mixed>> */
    public function invalidProvider(): array
    {
        $list = [];

        $list['iso 8601 dirty']               = $this->makeIncorrectItem('00002024-12-31xxx');
        $list['european format dirty']        = $this->makeIncorrectItem('31/12//2024');
        $list['us format dirty']              = $this->makeIncorrectItem('xxx12/31/2024');
        $list['alternative format dirty']     = $this->makeIncorrectItem('rr2x024.12.31');
        $list['abbreviated month name dirty'] = $this->makeIncorrectItem('xxx31-Dec-2024');
        $list['full month name dirty']        = $this->makeIncorrectItem('xxxDecember 31, 2024');

        $list['iso 8601 invalid month'] = $this->makeIncorrectItem('2024-13-31');
        $list['iso 8601 invalid day']   = $this->makeIncorrectItem('2024-12-32');

        $list['european format month'] = $this->makeIncorrectItem('31/13/2024');
        $list['european format day']   = $this->makeIncorrectItem('32/12/2024');

        $list['us format month'] = $this->makeIncorrectItem('13/31/2024');
        $list['us format day']   = $this->makeIncorrectItem('12/32/2024');

        $list['alternative format month'] = $this->makeIncorrectItem('2024.13.31');
        $list['alternative format day']   = $this->makeIncorrectItem('2024.12.32');

        $list['abbreviated month name month'] = $this->makeIncorrectItem('31-Err-2024');
        $list['abbreviated month name day']   = $this->makeIncorrectItem('32-Dec-2024');

        $list['full month name month'] = $this->makeIncorrectItem('Invalid 31, 2024');
        $list['full month name day']   = $this->makeIncorrectItem('December 32, 2024');

        $list['stringable invalid'] = $this->makeIncorrectItem($this->makeStringableObject('December 32, 2024'));

        $list['empty string']      = $this->makeIncorrectItem('');
        $list['one space string']  = $this->makeIncorrectItem(' ');
        $list['two spaces string'] = $this->makeIncorrectItem('  ');
        $list['array']             = $this->makeIncorrectItem(['a']);
        $list['object']            = $this->makeIncorrectItem(new stdClass());
        $list['false']             = $this->makeIncorrectItem(false);
        $list['true']              = $this->makeIncorrectItem(true);
        $list['null']              = $this->makeIncorrectItem(null);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotDate(mixed $dateValue): void
    {
        $assertion = new IsDate($dateValue);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid date"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotDate(mixed $dateValue): void
    {
        $assertion = new IsDate($dateValue);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid date"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotDateWithCustomMessage(
        mixed $dateValue,
        string $message
    ): void {
        $assertion = new IsDate($dateValue);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotDateWithCustomMessage(
        mixed $dateValue,
        string $message
    ): void {
        $assertion = new IsDate($dateValue);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
