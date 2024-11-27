<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\LessThan;
use Tests\TestCase;

class LessThanTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 8];
        $list['int'] = [9, 10];
        $list['float'] = [9.7, 9.8];
        $list['float + int'] = [9.9, 10];
        $list['array'] = [[1, 2, 3], 4];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(mixed $value, float|int $length): void
    {
        $assertion = new LessThan($value, $length);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 6, "O valor Palavra está errado"];
        $list['string utf8'] = ['coração', 6, "O valor coração está errado"]; // exatamente 7 caracteres
        $list['int'] = [9, 8, "O valor 9 está errado"];
        $list['float'] = [9.9, 9.0, "O valor 9.9 está errado"];
        $list['float + int'] = [9.8, 9, "O valor 9.8 está errado"];

        $value = str_replace([':', '{', '}'], ['=>', '[', ']'], (string)json_encode([1, 2, 3]));

        $list['array equal'] = [[1, 2, 3], 3, "O valor $value está errado"];
        $list['array greater'] = [[1, 2, 3], 2, "O valor $value está errado"];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(mixed $value, float|int $length): void
    {
        $assertion = new LessThan($value, $length);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be less than $length characters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value, float|int $length): void
    {
        $assertion = new LessThan($value, $length);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be less than $length characters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(
        mixed $value,
        float|int $length,
        string $message
    ): void {
        $assertion = new LessThan($value, $length);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(
        mixed $value,
        float|int $length,
        string $message
    ): void {
        $assertion = new LessThan($value, $length);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
