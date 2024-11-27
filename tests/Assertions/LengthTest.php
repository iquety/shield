<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\Length;
use Tests\TestCase;

class LengthTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 7];
        $list['string utf8'] = ['coração', 7]; // exatamente 7 caracteres
        $list['int'] = [9, 9];
        $list['float'] = [9.9, 9.9];

        $list['array'] = [[1, 2, 3], 3];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(mixed $value, float|int $length): void
    {
        $assertion = new Length($value, $length);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string maior'] = ['Palavra', 6, "O valor Palavra está errado"];
        $list['string menor'] = ['Palavra', 8, "O valor Palavra está errado"];
        $list['int'] = [9, 8, "O valor 9 está errado"];
        $list['float'] = [9.9, 9, "O valor 9.9 está errado"];

        $value = str_replace([':', '{', '}'], ['=>', '[', ']'], (string)json_encode([1, 2, 3]));

        $list['array greater'] = [[1, 2, 3], 2, "O valor $value está errado"];
        $list['array less'] = [[1, 2, 3], 4, "O valor $value está errado"];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(mixed $value, float|int $length): void
    {
        $assertion = new Length($value, $length);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be less length $length",
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value, float|int $length): void
    {
        $assertion = new Length($value, $length);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the 'name' field must be less length $length"
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
        $assertion = new Length($value, $length);

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
        $assertion = new Length($value, $length);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
