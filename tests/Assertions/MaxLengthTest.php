<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
use ArrayObject;
use InvalidArgumentException;
use Iquety\Shield\Assertion\MaxLength;
use stdClass;

class MaxLengthTest extends AssertionCase
{
    /** @return array<string,array<mixed>> */
    public function invalidValueProvider(): array
    {
        $list = [];

        $list['null is invalid value']      = [null];
        $list['stdObject is invalid value'] = [new stdClass()];
        $list['true is invalid value']      = [true];
        $list['false is invalid value']     = [false];
        $list['integer is invalid value']   = [33];
        $list['float is invalid value']     = [3.3];

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidValueProvider
     */
    public function valueIsInvalid(mixed $value): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value is not valid');

        $assertion = new MaxLength($value, 1);

        $assertion->isValid();
    }

    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 10];
        $list['string utf8'] = ['coração', 7]; // exatamente 7 caracteres

        $list['array with 3 elements is max 3 length'] = [[1, 2, 3], 3];
        $list['array with 3 elements is max 4 length'] = [[1, 2, 3], 4];

        $list['countable with 3 elements is max 3 length'] = [new ArrayObject([1, 2, 3]), 3];
        $list['countable with 3 elements is max 4 length'] = [new ArrayObject([1, 2, 3]), 4];

        $list['countable interator with 3 elements is max 3 length'] = [new ArrayIterator([1, 2, 3]), 3];
        $list['countable interator with 3 elements is max 4 length'] = [new ArrayIterator([1, 2, 3]), 4];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsMaxLength(mixed $value, int $maxLength): void
    {
        $assertion = new MaxLength($value, $maxLength);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value, int $length): array
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

        $list['array with 3 elements is not max 2 length'] = $this->makeIncorrectItem([1, 2, 3], 2);

        $list['countable with 3 elements is not max 2 length']
            = $this->makeIncorrectItem(new ArrayObject([1, 2, 3]), 2);

        $list['countable interator with 3 elements is not max 2 length']
            = $this->makeIncorrectItem(new ArrayIterator([1, 2, 3]), 2);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function valueIsNotMaxLength(mixed $value, int $maxLength): void
    {
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
    public function namedValueIsNotMaxLength(mixed $value, int $maxLength): void
    {
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
        int $maxLength,
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
        int $maxLength,
        string $message
    ): void {
        $assertion = new MaxLength($value, $maxLength);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
