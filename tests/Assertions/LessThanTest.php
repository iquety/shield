<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\LessThan;

class LessThanTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string 7 chars is less than 8'] = ['Palavra', 8];
        $list['string utf8 7 chars is less than 8'] = ['coração', 8];

        $list['integer 9 is less than 10'] = [9, 10];
        $list['float 9.8 is less than 9.9'] = [9.8, 9.9];
        $list['float 9.8 is less than integer 10'] = [9.8, 10];

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements is less than 8'] = [$arrayValue, 8];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueLessThanLength(mixed $value, float|int $length): void
    {
        $assertion = new LessThan($value, $length);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value, float|int $length): array
    {
        $messageValue = $this->makeMessageValue($value);

        return [
            $value,
            $length,
            "O valor $messageValue está errado" // mensagem personalizada
        ];
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string 7 chars is not less than 7'] = $this->makeIncorrectItem('Palavra', 7);
        $list['string 7 chars is not less than 6'] = $this->makeIncorrectItem('Palavra', 6);

        $list['string utf8 7 chars is not less than 7'] = $this->makeIncorrectItem('Coração', 7);
        $list['string utf8 7 chars is not less than 6'] = $this->makeIncorrectItem('Coração', 6);

        $list['integer 9 is not less than 9'] = $this->makeIncorrectItem(9, 9);
        $list['integer 9 is not less than 8'] = $this->makeIncorrectItem(9, 8);

        $list['float 9.8 is not less than 9.8'] = $this->makeIncorrectItem(9.8, 9.8);
        $list['float 9.8 is not less than 9.7'] = $this->makeIncorrectItem(9.8, 9.7);

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements is not less than 7'] = $this->makeIncorrectItem($arrayValue, 7);
        $list['array with 7 elements is not less than 6'] = $this->makeIncorrectItem($arrayValue, 6);

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueNotLessThanLength(mixed $value, float|int $length): void
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
    public function namedValueNotLessThanLength(mixed $value, float|int $length): void
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
    public function namedValueNotLessThanLengthAndCustomMessage(
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
    public function valueNotLessThanLengthWithCustomMessage(
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
