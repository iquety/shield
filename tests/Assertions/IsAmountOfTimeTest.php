<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsAmountOfTime;
use stdClass;

class IsAmountOfTimeTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['less time'] = ['00:01:01'];
        $list['in time'] = ['23:59:59'];
        $list['greater time'] = ['66:59:59'];
        $list['greater time 2'] = ['999:59:59'];
        $list['greater time 3'] = ['9999:59:59'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueIsAmountOfTime(string $timeValue): void
    {
        $assertion = new IsAmountOfTime($timeValue);

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
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['in time']      = $this->makeIncorrectItem('23:62:62');
        $list['greater time'] = $this->makeIncorrectItem('66:62:62');
        $list['empty string'] = $this->makeIncorrectItem('');
        $list['boolean']      = $this->makeIncorrectItem(false);
        $list['array']        = $this->makeIncorrectItem(['a']);
        $list['object']       = $this->makeIncorrectItem(new stdClass());

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotAmountOfTime(mixed $timeValue): void
    {
        $assertion = new IsAmountOfTime($timeValue);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid amount of time"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotAmountOfTime(mixed $timeValue): void
    {
        $assertion = new IsAmountOfTime($timeValue);

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
        $assertion = new IsAmountOfTime($timeValue);

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
        $assertion = new IsAmountOfTime($timeValue);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
