<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
use ArrayObject;
use InvalidArgumentException;
use Iquety\Shield\Assertion\GreaterThanOrEqualTo;
use stdClass;

class GreaterThanOrEqualToTest extends AssertionCase
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

        $assertion = new GreaterThanOrEqualTo($value, 1);

        $assertion->isValid();
    }

    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['numeric string 9 is greater than or equal to 9'] = ['9', 9];
        $list['numeric string 9 is greater than or equal to 8'] = ['9', 8];

        $list['integer 9 is greater than or equal to 9'] = [9, 9];
        $list['integer 9 is greater than or equal to 8'] = [9, 8];

        $list['float 9.9 is greater than or equal to 9.9'] = [9.9, 9.9];
        $list['float 9.9 is greater than or equal to 9.0'] = [9.9, 9.0];

        $list['float 9.8 is greater than or equal to integer 9.8'] = [9.8, 9.8];
        $list['float 9.8 is greater than or equal to integer 9'] = [9.8, 9];

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements is greater than or equal 7'] = [$arrayValue, 7];
        $list['array with 7 elements is greater than or equal 6.5'] = [$arrayValue, 6.5];
        $list['array with 7 elements is greater than or equal 6'] = [$arrayValue, 6];

        $list['countable with 7 elements is greater or equal than 7'] = [new ArrayObject($arrayValue), 7];
        $list['countable with 7 elements is greater or equal than 6.5'] = [new ArrayObject($arrayValue), 6.5];
        $list['countable with 7 elements is greater or equal than 6'] = [new ArrayObject($arrayValue), 6];

        $list['countable iterator with 7 elements is greater or equal than 7']
            = [new ArrayIterator($arrayValue), 7];
        $list['countable iterator with 7 elements is greater or equal than 6.5']
            = [new ArrayIterator($arrayValue), 6.5];
        $list['countable iterator with 7 elements is greater or equal than 6']
            = [new ArrayIterator($arrayValue), 6];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueGreaterOrEqualTo(mixed $value, float|int $length): void
    {
        $assertion = new GreaterThanOrEqualTo($value, $length);

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

        $list['numeric string'] = $this->makeIncorrectItem('9', 10);
        $list['int']            = $this->makeIncorrectItem(9, 10);
        $list['float']          = $this->makeIncorrectItem(9.9, 10.0);
        $list['float + int']    = $this->makeIncorrectItem(9.8, 10);
        $list['array less']     = $this->makeIncorrectItem([1, 2, 3], 4);

        $list['countable with 3 elements is not greater than or equal to 4']
            = $this->makeIncorrectItem(new ArrayObject(['a', 'b', 'c']), 4);

        $list['countable iterator with 3 elements is not greater than or equal to 4']
            = $this->makeIncorrectItem(new ArrayIterator(['a', 'b', 'c']), 4);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotGreaterOrEqualTo(mixed $value, float|int $length): void
    {
        $assertion = new GreaterThanOrEqualTo($value, $length);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be greater or equal to $length characters"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueNotGreaterOrEqualTo(mixed $value, float|int $length): void
    {
        $assertion = new GreaterThanOrEqualTo($value, $length);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be greater or equal to $length characters"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueNotGreaterOrEqualToWithCustomMessage(
        mixed $value,
        float|int $length,
        string $message
    ): void {
        $assertion = new GreaterThanOrEqualTo($value, $length);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotGreaterOrEqualToWithCustomMessage(
        mixed $value,
        float|int $length,
        string $message
    ): void {
        $assertion = new GreaterThanOrEqualTo($value, $length);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
