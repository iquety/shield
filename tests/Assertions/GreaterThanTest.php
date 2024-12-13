<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\GreaterThan;
use stdClass;

class GreaterThanTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string 7 chars is greater than 6'] = ['Palavra', 6];
        $list['string utf8 7 chars is greater than 6'] = ['coração', 6];

        $list['integer 9 is greater than 8'] = [9, 8];
        $list['float 9.9 is greater than 9.0'] = [9.9, 9.0];
        $list['float 9.8 is greater than integer 9'] = [9.8, 9];

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements is greater than 6'] = [$arrayValue, 6];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueGreaterThanLength(mixed $value, float|int $length): void
    {
        $assertion = new GreaterThan($value, $length);

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

        $list['string 7 chars is not greater than 7'] = $this->makeIncorrectItem('Palavra', 7);
        $list['string 7 chars is not greater than 8'] = $this->makeIncorrectItem('Palavra', 8);

        $list['string utf8 7 chars is not greater than 7'] = $this->makeIncorrectItem('Coração', 7);
        $list['string utf8 7 chars is not greater than 8'] = $this->makeIncorrectItem('Coração', 8);

        $list['integer 9 is not greater than 9'] = $this->makeIncorrectItem(9, 9);
        $list['integer 9 is not greater than 10'] = $this->makeIncorrectItem(9, 10);

        $list['float 9.8 is not greater than 9.8'] = $this->makeIncorrectItem(9.8, 9.8);
        $list['float 9.8 is not greater than 9.9'] = $this->makeIncorrectItem(9.8, 9.9);

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements is not greater than 7'] = $this->makeIncorrectItem($arrayValue, 7);
        $list['array with 7 elements is not greater than 8'] = $this->makeIncorrectItem($arrayValue, 8);

        $list['object not valid'] = $this->makeIncorrectItem(new stdClass(), 0);

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueNotGreaterThanLength(mixed $value, float|int $length): void
    {
        $assertion = new GreaterThan($value, $length);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be greater than $length characters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueNotGreaterThanLength(mixed $value, float|int $length): void
    {
        $assertion = new GreaterThan($value, $length);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be greater than $length characters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueNotGreaterThanLengthAndCustomMessage(
        mixed $value,
        float|int $length,
        string $message
    ): void {
        $assertion = new GreaterThan($value, $length);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueNotGreaterThanLengthAndCustomMessage(
        mixed $value,
        float|int $length,
        string $message
    ): void {
        $assertion = new GreaterThan($value, $length);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
