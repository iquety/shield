<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayObject;
use Iquety\Shield\Assertion\MaxLength;
use stdClass;

class MaxLengthTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 10];
        $list['string utf8'] = ['coração', 7]; // exatamente 7 caracteres
        $list['int'] = [9, 10];
        $list['float'] = [9.9, 10];
        $list['float + int'] = [9.8, 9.9];

        $list['array 3 -> 3'] = [[1, 2, 3], 3];
        $list['array 3 -> 4'] = [[1, 2, 3], 4];

        $list['countable 3 -> 3'] = [new ArrayObject([1, 2, 3]), 3];
        $list['countable 3 -> 4'] = [new ArrayObject([1, 2, 3]), 4];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsMaxLength(mixed $value, float|int $maxLength): void
    {
        $assertion = new MaxLength($value, $maxLength);

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

        $list['string']      = $this->makeIncorrectItem('Palavra', 5);
        $list['int']         = $this->makeIncorrectItem(9, 5);
        $list['float']       = $this->makeIncorrectItem(9.9, 5);
        $list['float + int'] = $this->makeIncorrectItem(9.9, 9.8);

        $list['array'] = $this->makeIncorrectItem([1, 2, 3], 2);
        $list['countable'] = $this->makeIncorrectItem(new ArrayObject([1, 2, 3]), 2);
        $list['object not valid'] = $this->makeIncorrectItem(new stdClass(), 0);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function valueIsNotMaxLength(
        mixed $value,
        float|int $maxLength
    ): void {
        $assertion = new MaxLength($value, $maxLength);

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be less than $maxLength characters"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotMaxLength(
        mixed $value,
        float|int $maxLength
    ): void {
        $assertion = new MaxLength($value, $maxLength);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be less than $maxLength characters"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotMaxLengthWithCustomMessage(
        mixed $value,
        float|int $maxLength,
        string $message
    ): void {
        $assertion = new MaxLength($value, $maxLength);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotMaxLengthWithCustomMessage(
        mixed $value,
        float|int $maxLength,
        string $message
    ): void {
        $assertion = new MaxLength($value, $maxLength);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
