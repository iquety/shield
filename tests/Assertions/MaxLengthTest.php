<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Shield\Assertion\MaxLength;
use Tests\TestCase;

class MaxLengthTest extends TestCase
{
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 10];
        $list['string utf8'] = ['coração', 7]; // exatamente 7 caracteres
        $list['int'] = [9, 10];
        $list['float'] = [9.9, 10];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(mixed $value, int $maxLength): void
    {
        $assertion = new MaxLength($value, $maxLength);

        $this->assertTrue($assertion->isValid());
    }

    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 5];
        $list['int'] = [9, 5];
        $list['float'] = [9.9, 5];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(mixed $value, int $maxLength): void
    {
        $assertion = new MaxLength($value, $maxLength);

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "The value must have a maximum of $maxLength characters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value, int $maxLength): void
    {
        $assertion = new MaxLength($value, $maxLength);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "The value of the field 'name' must have a maximum of 5 characters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(mixed $value, int $maxLength): void
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
    public function notAssertedCaseWithCustomMessage(mixed $value, int $maxLength): void
    {
        $assertion = new MaxLength($value, $maxLength);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $value está errado");
    }
}
