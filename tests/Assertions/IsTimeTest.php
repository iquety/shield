<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsTime;
use Tests\TestCase;

class IsTimeTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['ISO 8601'] = ['23:59:59'];
        $list['US format am'] = ['11:59:59 AM'];
        $list['US format pm'] = ['11:59:59 PM'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $timeString): void
    {
        $assertion = new IsTime($timeString);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['ISO 8601 dirty'] = ['xxx23:59:59'];
        $list['US format dirty'] = ['xxx11:59:59 PM'];

        $list['ISO 8601 invalid hour'] = ['25:59:59'];
        $list['ISO 8601 invalid minute'] = ['20:62:59'];
        $list['ISO 8601 invalid second'] = ['20:59:62'];

        $list['US format hour am'] = ['13:59:59 AM'];
        $list['US format hour pm'] = ['13:59:59 PM'];

        $list['US format minute am'] = ['11:62:59 AM'];
        $list['US format minute pm'] = ['11:62:59 PM'];

        $list['US format second am'] = ['11:59:62 AM'];
        $list['US format second pm'] = ['11:59:62 PM'];


        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(string $timeString): void
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
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(string $timeString): void
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
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $timeString): void
    {
        $assertion = new IsTime($timeString);

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
        $assertion = new IsTime($timeString);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $timeString está errado");
    }
}
