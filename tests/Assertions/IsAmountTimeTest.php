<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsAmountTime;
use stdClass;
use Stringable;

class IsAmountTimeTest extends AssertionCase
{
    /** @return array<string,array<mixed>> */
    public function emptyProvider(): array
    {
        return [
            'empty string'  => [''],
            'empty integer' => [0],
            'empty array'   => [[]],
            'empty false'   => [false],
            'empty null'    => [null],
        ];
    }

    /**
     * @test
     * @dataProvider emptyProvider
     */
    public function valueIsEmpty(mixed $value): void
    {
        $assertion = new IsAmountTime($value);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['less time']      = ['00:01:01'];
        $list['in time']        = ['23:59:59'];
        $list['greater time']   = ['66:59:59'];
        $list['greater time 2'] = ['999:59:59'];
        $list['greater time 3'] = ['9999:59:59'];
        $list['stringable']     = [$this->makeStringableObject('9999:59:59')];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueIsAmountTime(string|Stringable $timeValue): void
    {
        $assertion = new IsAmountTime($timeValue);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['in time']           = $this->makeIncorrectItem('23:62:62');
        $list['greater time']      = $this->makeIncorrectItem('66:62:62');
        $list['one space string']  = $this->makeIncorrectItem(' ');
        $list['two spaces string'] = $this->makeIncorrectItem('  ');
        $list['array']             = $this->makeIncorrectItem(['a']);
        $list['object']            = $this->makeIncorrectItem(new stdClass());
        $list['true']              = $this->makeIncorrectItem(true);
        $list['stringable']        = $this->makeIncorrectItem($this->makeStringableObject('23:62:62'));

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotAmountOfTime(mixed $timeValue): void
    {
        $assertion = new IsAmountTime($timeValue);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            'Value must be a valid amount of time'
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotAmountOfTime(mixed $timeValue): void
    {
        $assertion = new IsAmountTime($timeValue);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid amount of time"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotAmountOfTimeAndCustomMessage(mixed $timeValue, string $message): void
    {
        $assertion = new IsAmountTime($timeValue);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotAmountOfTimeWithCustomMessage(mixed $timeValue, string $message): void
    {
        $assertion = new IsAmountTime($timeValue);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
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
}
