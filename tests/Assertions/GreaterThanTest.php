<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
use ArrayObject;
use InvalidArgumentException;
use Iquety\Shield\Assertion\GreaterThan;
use stdClass;

class GreaterThanTest extends AssertionCase
{
    /** @return array<string,array<mixed>> */
    public function invalidValueProvider(): array
    {
        $list = [];

        $list['null is invalid value']      = [null];
        $list['stdObject is invalid value'] = [new stdClass()];
        $list['true is invalid value']      = [true];
        $list['false is invalid value']     = [false];

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

        $assertion = new GreaterThan($value, 1);

        $assertion->isValid();
    }

    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['string numeric 9 is greater than 8']  = ['9', 8];
        $list['integer 9 is greater than 8']         = [9, 8];
        $list['float 9.9 is greater than 9.0']       = [9.9, 9.0];
        $list['float 9.8 is greater than integer 9'] = [9.8, 9];

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements is greater than 6']       = [$arrayValue, 6];
        $list['array with 7 elements is greater than 6.5']     = [$arrayValue, 6.5];
        $list['countable with 7 elements is greater than 6']   = [new ArrayObject($arrayValue), 6];
        $list['countable with 7 elements is greater than 6.5'] = [new ArrayObject($arrayValue), 6.5];
        $list['countable with 7 elements is greater than 5']   = [new ArrayIterator($arrayValue), 5];
        $list['countable with 7 elements is greater than 5.5'] = [new ArrayIterator($arrayValue), 5.5];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
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
    public function invalidProvider(): array
    {
        $list = [];

        $list['numeric string 9 is not greater than 9'] = $this->makeIncorrectItem('9', 9);
        $list['numeric string 9 is not greater than 10'] = $this->makeIncorrectItem('9', 10);

        $list['integer 9 is not greater than 9'] = $this->makeIncorrectItem(9, 9);
        $list['integer 9 is not greater than 10'] = $this->makeIncorrectItem(9, 10);

        $list['float 9.8 is not greater than 9.8'] = $this->makeIncorrectItem(9.8, 9.8);
        $list['float 9.8 is not greater than 9.9'] = $this->makeIncorrectItem(9.8, 9.9);

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements is not greater than 7'] = $this->makeIncorrectItem($arrayValue, 7);
        $list['array with 7 elements is not greater than 7.5'] = $this->makeIncorrectItem($arrayValue, 7.5);
        $list['array with 7 elements is not greater than 8'] = $this->makeIncorrectItem($arrayValue, 8);

        $list['countable with 7 elements is not greater than 7']
            = $this->makeIncorrectItem(new ArrayObject($arrayValue), 7);
        $list['countable with 7 elements is not greater than 7.5']
            = $this->makeIncorrectItem(new ArrayObject($arrayValue), 7.5);

        $list['countable with 7 elements is not greater than 8']
            = $this->makeIncorrectItem(new ArrayObject($arrayValue), 8);
        $list['countable with 7 elements is not greater than 8.5']
            = $this->makeIncorrectItem(new ArrayObject($arrayValue), 8.5);

        $list['countable iterator with 7 elements is not greater than 7']
            = $this->makeIncorrectItem(new ArrayIterator($arrayValue), 7);
        $list['countable iterator with 7 elements is not greater than 7.5']
            = $this->makeIncorrectItem(new ArrayIterator($arrayValue), 7.5);

        $list['countable iterator with 7 elements is not greater than 8']
            = $this->makeIncorrectItem(new ArrayIterator($arrayValue), 8);
        $list['countable iterator with 7 elements is not greater than 8.5']
            = $this->makeIncorrectItem(new ArrayIterator($arrayValue), 8.5);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
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
     * @dataProvider invalidProvider
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
     * @dataProvider invalidProvider
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
     * @dataProvider invalidProvider
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
