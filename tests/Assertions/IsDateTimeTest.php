<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsDateTime;
use stdClass;

class IsDateTimeTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function valueProvider(): array
    {
        $list = [];

        $list['iso 8601'] = ['2024-12-31 23:59:59'];
        $list['european format'] = ['31/12/2024 23:59:59'];
        $list['us format am'] = ['12/31/2024 11:59:59 AM'];
        $list['us format pm'] = ['12/31/2024 11:59:59 PM'];
        $list['alternative format'] = ['2024.12.31 23:59:59'];
        $list['abbreviated month name'] = ['31-Dec-2024 23:59:59'];
        $list['full month name'] = ['December 31, 2024 23:59:59'];

        return $list;
    }

    /**
     * @test
     * @dataProvider valueProvider
     */
    public function valueIsDateTime(mixed $dateValue): void
    {
        $assertion = new IsDateTime($dateValue);

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
    public function invalueProvider(): array
    {
        $list = [];

        $list['iso 8601 dirty']               = $this->makeIncorrectItem('00002024-12-31xxx 23:59:59');
        $list['european format dirty']        = $this->makeIncorrectItem('31/12//2024 23:59:59');
        $list['us format dirty']              = $this->makeIncorrectItem('xxx12/31/2024 11:59:59 PM');
        $list['alternative format dirty']     = $this->makeIncorrectItem('rr2x024.12.31 23:59:59');
        $list['abbreviated month name dirty'] = $this->makeIncorrectItem('xxx31-Dec-2024 23:59:59');
        $list['full month name dirty']        = $this->makeIncorrectItem('xxxDecember 31, 2024 23:59:59');

        $list['iso 8601 invalid month']  = $this->makeIncorrectItem('2024-13-31 23:59:59');
        $list['iso 8601 invalid day']    = $this->makeIncorrectItem('2024-12-32 23:59:59');
        $list['iso 8601 invalid hour']   = $this->makeIncorrectItem('2024-12-31 25:59:59');
        $list['iso 8601 invalid minute'] = $this->makeIncorrectItem('2024-12-31 20:62:59');
        $list['iso 8601 invalid second'] = $this->makeIncorrectItem('2024-12-31 20:59:62');

        $list['european format month']  = $this->makeIncorrectItem('31/13/2024 23:59:59');
        $list['european format day']    = $this->makeIncorrectItem('32/12/2024 23:59:59');
        $list['european format hour']   = $this->makeIncorrectItem('31/12/2024 28:59:59');
        $list['european format minute'] = $this->makeIncorrectItem('31/12/2024 23:62:59');
        $list['european format second'] = $this->makeIncorrectItem('31/12/2024 23:59:62');

        $list['us format month am']  = $this->makeIncorrectItem('13/31/2024 11:59:59 AM');
        $list['us format day am']    = $this->makeIncorrectItem('12/32/2024 11:59:59 AM');
        $list['us format hour am']   = $this->makeIncorrectItem('12/31/2024 26:59:59 AM');
        $list['us format minute am'] = $this->makeIncorrectItem('12/31/2024 11:62:59 AM');
        $list['us format second am'] = $this->makeIncorrectItem('12/31/2024 11:59:62 AM');

        $list['us format month pm']  = $this->makeIncorrectItem('13/31/2024 11:59:59 PM');
        $list['us format day pm']    = $this->makeIncorrectItem('12/32/2024 11:59:59 PM');
        $list['us format hour pm']   = $this->makeIncorrectItem('12/31/2024 26:59:59 PM');
        $list['us format minute pm'] = $this->makeIncorrectItem('12/31/2024 11:62:59 PM');
        $list['us format second pm'] = $this->makeIncorrectItem('12/31/2024 11:59:62 PM');

        $list['alternative format month']  = $this->makeIncorrectItem('2024.13.31 23:59:59');
        $list['alternative format day']    = $this->makeIncorrectItem('2024.12.32 23:59:59');
        $list['alternative format hour']   = $this->makeIncorrectItem('2024.12.31 27:59:59');
        $list['alternative format minute'] = $this->makeIncorrectItem('2024.12.31 23:62:59');
        $list['alternative format second'] = $this->makeIncorrectItem('2024.12.31 23:59:62');

        $list['abbreviated month name month']  = $this->makeIncorrectItem('31-Err-2024 23:59:59');
        $list['abbreviated month name day']    = $this->makeIncorrectItem('32-Dec-2024 23:59:59');
        $list['abbreviated month name hour']   = $this->makeIncorrectItem('31-Dec-2024 27:59:59');
        $list['abbreviated month name minute'] = $this->makeIncorrectItem('31-Dec-2024 23:62:59');
        $list['abbreviated month name second'] = $this->makeIncorrectItem('31-Dec-2024 23:59:62');

        $list['full month name month']  = $this->makeIncorrectItem('Invalid 31, 2024 23:59:59');
        $list['full month name day']    = $this->makeIncorrectItem('December 32, 2024 23:59:59');
        $list['full month name hour']   = $this->makeIncorrectItem('December 31, 2024 27:59:59');
        $list['full month name minute'] = $this->makeIncorrectItem('December 31, 2024 23:62:59');
        $list['full month name second'] = $this->makeIncorrectItem('December 31, 2024 23:59:62');

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
     * @dataProvider invalueProvider
     */
    public function valueIsNotDateTime(mixed $dateValue): void
    {
        $assertion = new IsDateTime($dateValue);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid date and time"
        );
    }

    /**
     * @test
     * @dataProvider invalueProvider
     */
    public function namedValueIsNotDateTime(mixed $dateValue): void
    {
        $assertion = new IsDateTime($dateValue);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid date and time"
        );
    }

    /**
     * @test
     * @dataProvider invalueProvider
     */
    public function namedValueIsNotDateTimeWithCustomMessage(
        mixed $dateValue,
        string $message
    ): void {
        $assertion = new IsDateTime($dateValue);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalueProvider
     */
    public function valueIsNotDateTimeWithCustomMessage(
        mixed $dateValue,
        string $message
    ): void {
        $assertion = new IsDateTime($dateValue);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
