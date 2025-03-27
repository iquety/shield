<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
use ArrayObject;
use InvalidArgumentException;
use Iquety\Shield\Assertion\Length;
use stdClass;

class LengthTest extends AssertionCase
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

        $assertion = new Length($value, 1);

        $assertion->isValid();
    }

    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['string 7 chars has length 7']      = ['Palavra', 7];
        $list['string utf8 7 chars has length 7'] = ['coração', 7];

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements has length 7'] = [$arrayValue, 7];

        $list['countable with 7 elements has length 7'] = [new ArrayObject($arrayValue), 7];

        $list['countable iterator with 7 elements is length 7'] = [new ArrayIterator($arrayValue), 7];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueHasLength(mixed $value, int $length): void
    {
        $assertion = new Length($value, $length);

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

        $list['string 7 chars has not length 8'] = $this->makeIncorrectItem('Palavra', 8);
        $list['string 7 chars has not length 6'] = $this->makeIncorrectItem('Palavra', 6);

        $list['string utf8 7 chars has not length 8'] = $this->makeIncorrectItem('coração', 8);
        $list['string utf8 7 chars has not length 6'] = $this->makeIncorrectItem('coração', 6);

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements has not length 8'] = $this->makeIncorrectItem($arrayValue, 8);
        $list['array with 7 elements has not length 6'] = $this->makeIncorrectItem($arrayValue, 6);

        $list['countable with 7 elements has length 8'] = $this->makeIncorrectItem(new ArrayObject($arrayValue), 8);
        $list['countable with 7 elements has length 6'] = $this->makeIncorrectItem(new ArrayObject($arrayValue), 6);

        $list['countable iterator with 7 elements has length 8']
            = $this->makeIncorrectItem(new ArrayIterator($arrayValue), 8);

        $list['countable iterator with 7 elements has length 6']
            = $this->makeIncorrectItem(new ArrayIterator($arrayValue), 6);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotHasLength(mixed $value, int $length): void
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
     * @dataProvider invalidProvider
     */
    public function namedValueNotHasLength(mixed $value, int $length): void
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
     * @dataProvider invalidProvider
     */
    public function namedValueHasLengthAndCustomMessage(
        mixed $value,
        int $length,
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
     * @dataProvider invalidProvider
     */
    public function valueHasLengthAndCustomMessage(
        mixed $value,
        int $length,
        string $message
    ): void {
        $assertion = new Length($value, $length);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
