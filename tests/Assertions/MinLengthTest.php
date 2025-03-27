<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
use ArrayObject;
use InvalidArgumentException;
use Iquety\Shield\Assertion\MinLength;
use stdClass;

class MinLengthTest extends AssertionCase
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

        $assertion = new MinLength($value, 1);

        $assertion->isValid();
    }

    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['string'] = ['Palavra', 5];
        $list['string utf8'] = ['coração', 7]; // exatamente 7 caracteres

        $list['array with 3 elements is min 2 length'] = [[1, 2, 3], 2];
        $list['array with 3 elements is min 3 length'] = [[1, 2, 3], 3];

        $list['countable with 3 elements is min 2 length'] = [new ArrayObject([1, 2, 3]), 2];
        $list['countable with 3 elements is min 3 length'] = [new ArrayObject([1, 2, 3]), 3];

        $list['countable interator with 3 elements is min 2 length'] = [new ArrayIterator([1, 2, 3]), 2];
        $list['countable interator with 3 elements is min 3 length'] = [new ArrayIterator([1, 2, 3]), 3];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsMinLength(mixed $value, int $minLength): void
    {
        $assertion = new MinLength($value, $minLength);

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

        $list['string']           = $this->makeIncorrectItem('Palavra', 10);

        $list['array with 3 elements is not min 4 length']
            = $this->makeIncorrectItem([1, 2, 3], 4);

        $list['countable with 3 elements is not min 4 length']
            = $this->makeIncorrectItem(new ArrayObject([1, 2, 3]), 4);

        $list['countable interator with 3 elements is not min 4 length']
            = $this->makeIncorrectItem(new ArrayIterator([1, 2, 3]), 4);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function valueIsNotMinLength(mixed $value, int $minLength): void
    {
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
    public function namedValueIsNotMinLength(mixed $value, int $minLength): void
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
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotMinLengthWithCustomMessage(mixed $value, int $minLength, string $message): void
    {
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
    public function valueIsNotMinLengthWithCustomMessage(mixed $value, int $minLength, string $message): void
    {
        $assertion = new MinLength($value, $minLength);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
