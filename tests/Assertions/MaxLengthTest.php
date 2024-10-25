<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\MaxLength;
use Tests\TestCase;

class MaxLengthTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 10];
        $list['string utf8'] = ['coração', 7]; // exatamente 7 caracteres
        $list['int'] = [9, 10];
        $list['float'] = [9.9, 10];
        $list['float + int'] = [9.8, 9.9];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(mixed $value, float|int $maxLength): void
    {
        $assertion = new MaxLength($value, $maxLength);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 5];
        $list['int'] = [9, 5];
        $list['float'] = [9.9, 5];
        $list['float + int'] = [9.9, 9.8];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(mixed $value, float|int $maxLength): void
    {
        $assertion = new MaxLength($value, $maxLength);

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be less than $maxLength characters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value, float|int $maxLength): void
    {
        $assertion = new MaxLength($value, $maxLength);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be less than $maxLength characters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(mixed $value, float|int $maxLength): void
    {
        $assertion = new MaxLength($value, $maxLength);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $value está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(mixed $value, float|int $maxLength): void
    {
        $assertion = new MaxLength($value, $maxLength);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $value está errado");
    }
}
