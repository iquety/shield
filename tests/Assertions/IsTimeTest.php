<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsTime;
use stdClass;

class IsTimeTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['ISO 8601']     = ['23:59:59'];
        $list['US format am'] = ['11:59:59 AM'];
        $list['US format pm'] = ['11:59:59 PM'];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function assertedCase(string $timeString): void
    {
        $assertion = new IsTime($timeString);

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

        $list['ISO 8601 dirty']  = $this->makeIncorrectItem('xxx23:59:59');
        $list['US format dirty'] = $this->makeIncorrectItem('xxx11:59:59 PM');

        $list['ISO 8601 invalid hour']   = $this->makeIncorrectItem('25:59:59');
        $list['ISO 8601 invalid minute'] = $this->makeIncorrectItem('20:62:59');
        $list['ISO 8601 invalid second'] = $this->makeIncorrectItem('20:59:62');

        $list['US format hour am'] = $this->makeIncorrectItem('13:59:59 AM');
        $list['US format hour pm'] = $this->makeIncorrectItem('13:59:59 PM');

        $list['US format minute am'] = $this->makeIncorrectItem('11:62:59 AM');
        $list['US format minute pm'] = $this->makeIncorrectItem('11:62:59 PM');

        $list['US format second am'] = $this->makeIncorrectItem('11:59:62 AM');
        $list['US format second pm'] = $this->makeIncorrectItem('11:59:62 PM');

        $list['empty string']      = $this->makeIncorrectItem('');
        $list['one space string']  = $this->makeIncorrectItem(' ');
        $list['two spaces string'] = $this->makeIncorrectItem('  ');
        $list['boolean']           = $this->makeIncorrectItem(false);
        $list['array']             = $this->makeIncorrectItem(['a']);
        $list['object']            = $this->makeIncorrectItem(new stdClass());
        $list['null']              = $this->makeIncorrectItem(null);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotTime(mixed $timeString): void
    {
        $assertion = new IsTime($timeString);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid time"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotTime(mixed $timeString): void
    {
        $assertion = new IsTime($timeString);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid time"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotTimeWithCustomMessage(
        mixed $timeValue,
        string $message
    ): void {
        $assertion = new IsTime($timeValue);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotTimeWithCustomMessage(mixed $timeValue, string $message): void
    {
        $assertion = new IsTime($timeValue);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
