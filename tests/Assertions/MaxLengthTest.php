<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
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

        $list['array with 3 elements is max 3 length'] = [[1, 2, 3], 3];
        $list['array with 3 elements is max 4 length'] = [[1, 2, 3], 4];

        $list['countable with 3 elements is max 3 length'] = [new ArrayObject([1, 2, 3]), 3];
        $list['countable with 3 elements is max 4 length'] = [new ArrayObject([1, 2, 3]), 4];

        $list['countable interator with 3 elements is max 3 length'] = [new ArrayIterator([1, 2, 3]), 3];
        $list['countable interator with 3 elements is max 4 length'] = [new ArrayIterator([1, 2, 3]), 4];

        $stdObject        = new stdClass();
        $stdObject->one   = 'Meu';
        $stdObject->two   = 'Texto';
        $stdObject->three = 'Legal';
        $list['stdClass with 3 public properties is max than 3 length'] = [$stdObject, 3];
        $list['stdClass with 3 public properties is max than 4 length'] = [$stdObject, 4];

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

        $list['array with 3 elements is not max 2 length'] = $this->makeIncorrectItem([1, 2, 3], 2);

        $list['countable with 3 elements is not max 2 length']
            = $this->makeIncorrectItem(new ArrayObject([1, 2, 3]), 2);

        $list['countable interator with 3 elements is not max 2 length']
            = $this->makeIncorrectItem(new ArrayIterator([1, 2, 3]), 2);

        $stdObject        = new stdClass();
        $stdObject->one   = 'Meu';
        $stdObject->two   = 'Texto';
        $stdObject->three = 'Legal';
        $list['stdClass with 3 public properties is not max than 2 length'] = $this->makeIncorrectItem($stdObject, 2);

        $list['null is invalid'] = $this->makeIncorrectItem(null, 0);
        $list['false is invalid'] = $this->makeIncorrectItem(false, 0);
        $list['true is invalid'] = $this->makeIncorrectItem(true, 0);

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
