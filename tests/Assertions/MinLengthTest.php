<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\MinLength;
use stdClass;
use Tests\TestCase;

class MinLengthTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 5];
        $list['string utf8'] = ['coração', 7]; // exatamente 7 caracteres
        $list['int'] = [9, 5];
        $list['float + int'] = [9.9, 5];
        $list['float'] = [9.9, 5.5];

        $list['array 3 -> 0'] = [[1, 2, 3], 0];
        $list['array 3 -> 1'] = [[1, 2, 3], 1];
        $list['array 3 -> 2'] = [[1, 2, 3], 2];
        $list['array 3 -> 3'] = [[1, 2, 3], 3];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(mixed $value, float|int $minLength): void
    {
        $assertion = new MinLength($value, $minLength);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 10, 'Palavra', '10'];
        $list['int'] = [9, 10, '9', '10'];
        $list['float'] = [9.9, 10, '9.9', '10'];
        $list['float + int'] = [9.8, 9.9, '9.8', '9.9'];

        $value = str_replace([':', '{', '}'], ['=>', '[', ']'], (string)json_encode([1, 2, 3]));

        $list['array'] = [[1, 2, 3], 4, $value, '4'];

        $list['object not valid'] = [new stdClass(), 0, 'stdClass:[]', '0'];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function notAssertedCase(
        mixed $value,
        float|int $minLength,
        string $valueString,
        string $lengthString
    ): void {
        $assertion = new MinLength($value, $minLength);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be greater than $lengthString characters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value, float|int $minLength): void
    {
        $assertion = new MinLength($value, $minLength);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be greater than $minLength characters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(
        mixed $value,
        float|int $minLength,
        string $valueString
    ): void {
        $assertion = new MinLength($value, $minLength);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $valueString está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(
        mixed $value,
        float|int $minLength,
        string $valueString
    ): void {
        $assertion = new MinLength($value, $minLength);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $valueString está errado");
    }
}
