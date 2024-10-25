<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\LessThanOrEqualTo;
use Tests\TestCase;

class LessThanOrEqualToTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string less'] = ['Palavra', 8];
        $list['int less'] = [9, 10];
        $list['float less'] = [9.7, 9.8];
        $list['float + int less'] = [9.9, 10];

        $list['string equal'] = ['Palavra', 7];
        $list['int equal'] = [9, 9];
        $list['float equal'] = [9.7, 9.7];
        $list['float + int equal'] = [9.9, 9.9];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(mixed $value, float|int $length): void
    {
        $assertion = new LessThanOrEqualTo($value, $length);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 6];
        $list['string utf8'] = ['coração', 6]; // exatamente 7 caracteres
        $list['int'] = [9, 8];
        $list['float'] = [9.9, 9.0];
        $list['float + int'] = [9.8, 9];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(mixed $value, float|int $length): void
    {
        $assertion = new LessThanOrEqualTo($value, $length);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be less or equal to $length characters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value, float|int $length): void
    {
        $assertion = new LessThanOrEqualTo($value, $length);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be less or equal to $length characters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(mixed $value, float|int $length): void
    {
        $assertion = new LessThanOrEqualTo($value, $length);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), "O valor $value está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(mixed $value, float|int $length): void
    {
        $assertion = new LessThanOrEqualTo($value, $length);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), "O valor $value está errado");
    }
}
