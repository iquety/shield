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

        $list['string 7 chars is greater than or equal to 7'] = ['Palavra', 7];
        $list['string 7 chars is greater than or equal to 6'] = ['Palavra', 6];

        $list['string utf8 7 chars is greater than or equal to 7'] = ['coração', 7];
        $list['string utf8 7 chars is greater than or equal to 6'] = ['coração', 6];

        $list['integer 9 is greater than or equal to 9'] = [9, 9];
        $list['integer 9 is greater than or equal to 8'] = [9, 8];

        $list['float 9.9 is greater than or equal to 9.9'] = [9.9, 9.9];
        $list['float 9.9 is greater than or equal to 9.0'] = [9.9, 9.0];

        $list['float 9.8 is greater than or equal to integer 9.8'] = [9.8, 9.8];
        $list['float 9.8 is greater than or equal to integer 9'] = [9.8, 9];

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements is greater than 7'] = [$arrayValue, 7];
        $list['array with 7 elements is greater than 6'] = [$arrayValue, 6];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueGreaterOrEqualTo(mixed $value, float|int $length): void
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
    public function valueNotGreaterOrEqualTo(mixed $value, float|int $length): void
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
    public function namedValueNotGreaterOrEqualTo(mixed $value, float|int $length): void
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
    public function namedValueNotGreaterOrEqualToWithCustomMessage(
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
    public function valueNotGreaterOrEqualToWithCustomMessage(
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
