<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
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

        $list['array with 3 elements is min 2 length'] = [[1, 2, 3], 2];
        $list['array with 3 elements is min 3 length'] = [[1, 2, 3], 3];

        $list['countable with 3 elements is min 2 length'] = [new ArrayObject([1, 2, 3]), 2];
        $list['countable with 3 elements is min 3 length'] = [new ArrayObject([1, 2, 3]), 3];

        $list['countable interator with 3 elements is min 2 length'] = [new ArrayIterator([1, 2, 3]), 2];
        $list['countable interator with 3 elements is min 3 length'] = [new ArrayIterator([1, 2, 3]), 3];

        $stdObject        = new stdClass();
        $stdObject->one   = 'Meu';
        $stdObject->two   = 'Texto';
        $stdObject->three = 'Legal';
        $list['stdClass with 3 public properties is min than 2 length'] = [$stdObject, 2];
        $list['stdClass with 3 public properties is min than 3 length'] = [$stdObject, 3];

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

        $list['array with 3 elements is not min 4 length']
            = $this->makeIncorrectItem([1, 2, 3], 4);

        $list['countable with 3 elements is not min 4 length']
            = $this->makeIncorrectItem(new ArrayObject([1, 2, 3]), 4);

        $list['countable interator with 3 elements is not min 4 length']
            = $this->makeIncorrectItem(new ArrayIterator([1, 2, 3]), 4);

        $stdObject        = new stdClass();
        $stdObject->one   = 'Meu';
        $stdObject->two   = 'Texto';
        $stdObject->three = 'Legal';
        $list['stdClass with 3 public properties is not min than 4 length'] = $this->makeIncorrectItem($stdObject, 4);

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
