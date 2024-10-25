<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsAmountOfTime;
use Tests\TestCase;

class IsAmountOfTimeTest extends TestCase
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
    public function assertedCase(string $timeString): void
    {
        $assertion = new IsAmountOfTime($timeString);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['in time'] = ['23:62:62'];
        $list['greater time'] = ['66:62:62'];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(string $timeString): void
    {
        $assertion = new IsAmountOfTime($timeString);

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
    public function notAssertedCaseWithNamedAssertion(string $timeString): void
    {
        $assertion = new IsAmountOfTime($timeString);

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
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $timeString): void
    {
        $assertion = new IsAmountOfTime($timeString);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $timeString está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(string $timeString): void
    {
        $assertion = new IsAmountOfTime($timeString);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $timeString está errado");
    }
}
