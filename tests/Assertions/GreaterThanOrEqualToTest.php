<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\GreaterThanOrEqualTo;
use Tests\TestCase;

class GreaterThanOrEqualToTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string less'] = ['Palavra', 5];
        $list['int less'] = [9, 8];
        $list['float less'] = [9.7, 8.8];
        $list['float + int less'] = [9.9, 8];

        $list['string equal'] = ['Palavra', 7];
        $list['int equal'] = [9, 9];
        $list['float equal'] = [9.7, 9.7];
        $list['float + int equal'] = [9.9, 9.9];

        $list['array greater'] = [[1, 2, 3], 2];
        $list['array equal'] = [[1, 2, 3], 3];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(mixed $value, float|int $length): void
    {
        $assertion = new GreaterThanOrEqualTo($value, $length);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 10, "O valor Palavra está errado"];
        $list['string utf8'] = ['coração', 10, "O valor coração está errado"]; // exatamente 7 caracteres
        $list['int'] = [9, 10, "O valor 9 está errado"];
        $list['float'] = [9.9, 10.0, "O valor 9.9 está errado"];
        $list['float + int'] = [9.8, 10, "O valor 9.8 está errado"];

        $value = str_replace([':', '{', '}'], ['=>', '[', ']'], (string)json_encode([1, 2, 3]));

        $list['array less'] = [[1, 2, 3], 4, "O valor $value está errado"];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(mixed $value, float|int $length): void
    {
        $assertion = new GreaterThanOrEqualTo($value, $length);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be greater or equal to $length characters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value, float|int $length): void
    {
        $assertion = new GreaterThanOrEqualTo($value, $length);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be greater or equal to $length characters"
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
        $assertion = new GreaterThanOrEqualTo($value, $length);

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
        $assertion = new GreaterThanOrEqualTo($value, $length);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
