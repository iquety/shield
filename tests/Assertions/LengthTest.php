<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\Length;
use stdClass;

class LengthTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string 7 chars has length 7'] = ['Palavra', 7];
        $list['string utf8 7 chars has length 7'] = ['coração', 7];

        $list['integer 9 has length 9'] = [9, 9];
        $list['float 9.9 has length 9.9'] = [9.9, 9.9];

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements has length 7'] = [$arrayValue, 7];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueHasLength(mixed $value, float|int $length): void
    {
        $assertion = new Length($value, $length);

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

        $list['string 7 chars has not length 8'] = $this->makeIncorrectItem('Palavra', 8);
        $list['string 7 chars has not length 6'] = $this->makeIncorrectItem('Palavra', 6);

        $list['string utf8 7 chars has not length 8'] = $this->makeIncorrectItem('coração', 8);
        $list['string utf8 7 chars has not length 6'] = $this->makeIncorrectItem('coração', 6);

        $list['integer 9 has not length 10'] = $this->makeIncorrectItem(9, 10);
        $list['integer 9 has not length 8'] = $this->makeIncorrectItem(9, 8);

        $list['float 9.9 has not length 10.1'] = $this->makeIncorrectItem(9.9, 10.1);
        $list['float 9.9 has not length 9.8'] = $this->makeIncorrectItem(9.9, 9.8);

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements has not length 8'] = $this->makeIncorrectItem($arrayValue, 8);
        $list['array with 7 elements has not length 6'] = $this->makeIncorrectItem($arrayValue, 6);

        $list['object not valid'] = $this->makeIncorrectItem(new stdClass(), 0);

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueNotHasLength(mixed $value, float|int $length): void
    {
        $assertion = new Length($value, $length);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must have length $length",
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueNotHasLength(mixed $value, float|int $length): void
    {
        $assertion = new Length($value, $length);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the 'name' field must have length $length"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueHasLengthAndCustomMessage(
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
    public function valueHasLengthAndCustomMessage(
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
