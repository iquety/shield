<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayObject;
use Iquety\Shield\Assertion\MinLength;
use stdClass;

class MinLengthTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
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

        $list['countable 3 -> 0'] = [new ArrayObject([1, 2, 3]), 0];
        $list['countable 3 -> 1'] = [new ArrayObject([1, 2, 3]), 1];
        $list['countable 3 -> 2'] = [new ArrayObject([1, 2, 3]), 2];
        $list['countable 3 -> 3'] = [new ArrayObject([1, 2, 3]), 3];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsMinLength(mixed $value, float|int $minLength): void
    {
        $assertion = new MinLength($value, $minLength);

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
    public function invalidProvider(): array
    {
        $list = [];

        $list['string']           = $this->makeIncorrectItem('Palavra', 10);
        $list['int']              = $this->makeIncorrectItem(9, 10);
        $list['float']            = $this->makeIncorrectItem(9.9, 10);
        $list['float + int']      = $this->makeIncorrectItem(9.8, 9.9);
        $list['array']            = $this->makeIncorrectItem([1, 2, 3], 4, );
        $list['countable']        = $this->makeIncorrectItem(new ArrayObject([1, 2, 3]), 4, );
        $list['object not valid'] = $this->makeIncorrectItem(new stdClass(), 0);
        $list['null']             = $this->makeIncorrectItem(null, 0);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function valueIsNotMinLength(
        mixed $value,
        float|int $minLength
    ): void {
        $assertion = new MinLength($value, $minLength);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be greater than $minLength characters"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotMinLength(
        mixed $value,
        float|int $minLength
    ): void {
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
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotMinLengthWithCustomMessage(
        mixed $value,
        float|int $minLength,
        string $message
    ): void {
        $assertion = new MinLength($value, $minLength);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotMinLengthWithCustomMessage(
        mixed $value,
        float|int $minLength,
        string $message
    ): void {
        $assertion = new MinLength($value, $minLength);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
