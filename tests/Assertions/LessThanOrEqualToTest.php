<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
use ArrayObject;
use InvalidArgumentException;
use Iquety\Shield\Assertion\LessThanOrEqualTo;
use stdClass;

class LessThanOrEqualToTest extends AssertionCase
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

        $assertion = new LessThanOrEqualTo($value, 1);

        $assertion->isValid();
    }

    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['numeric string 9 is less than or equal to 9']  = ['9', 9];
        $list['numeric string 9 is less than or equal to 10'] = ['9', 10];

        $list['integer 9 is less than or equal to 9'] = [9, 9];
        $list['integer 9 is less than or equal to 9.5'] = [9, 9.5];
        $list['integer 9 is less than or equal to 10'] = [9, 10];

        $list['float 9.9 is less than or equal to 9.9'] = [9.9, 9.9];
        $list['float 9.8 is less than or equal to 9.9'] = [9.8, 9.9];

        $list['float 9.8 is less than or equal to integer 10'] = [9.8, 10];

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements is less than 7'] = [$arrayValue, 7];
        $list['array with 7 elements is less than 7.5'] = [$arrayValue, 7.5];
        $list['array with 7 elements is less than 8'] = [$arrayValue, 8];

        $list['countable with 7 elements is less than or equal 7'] = [new ArrayObject($arrayValue), 7];
        $list['countable with 7 elements is less than or equal 7.5'] = [new ArrayObject($arrayValue), 7.5];
        $list['countable with 7 elements is less than or equal 8'] = [new ArrayObject($arrayValue), 8];

        $list['countable iterator with 7 elements is less than or equal 7'] = [new ArrayIterator($arrayValue), 7];
        $list['countable iterator with 7 elements is less than or equal 7.5'] = [new ArrayIterator($arrayValue), 7.5];
        $list['countable iterator with 7 elements is less than or equal 8'] = [new ArrayIterator($arrayValue), 8];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueLessThanOrEqualToLength(mixed $value, float|int $length): void
    {
        $assertion = new LessThanOrEqualTo($value, $length);

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

        $list['numeric string 9 is not less than 8'] = $this->makeIncorrectItem('9', 8);
        $list['numeric string 9 is not less than 8.5'] = $this->makeIncorrectItem('9', 8.5);
        $list['integer 9 is not less than 8'] = $this->makeIncorrectItem(9, 8);
        $list['integer 9 is not less than 8.5'] = $this->makeIncorrectItem(9, 8.5);
        $list['float 9.8 is not less than 9.7'] = $this->makeIncorrectItem(9.8, 9.7);
        $list['float 9.8 is not less than 9'] = $this->makeIncorrectItem(9.8, 9);

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements is not less than 6'] = $this->makeIncorrectItem($arrayValue, 6);
        $list['array with 7 elements is not less than 6.5'] = $this->makeIncorrectItem($arrayValue, 6.5);

        $list['countable with 7 elements is not less than or equal 6']
            = $this->makeIncorrectItem(new ArrayObject($arrayValue), 6);
        $list['countable with 7 elements is not less than or equal 6.5']
            = $this->makeIncorrectItem(new ArrayObject($arrayValue), 6.5);

        $list['countable iterator with 7 elements is not less than or equal 6']
            = $this->makeIncorrectItem(new ArrayIterator($arrayValue), 6);
        $list['countable iterator with 7 elements is not less than or equal 6.5']
            = $this->makeIncorrectItem(new ArrayIterator($arrayValue), 6.5);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotLessThanOrEqualToLength(mixed $value, float|int $length): void
    {
        $assertion = new LessThanOrEqualTo($value, $length);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be less or equal to $length characters"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueNotLessThanOrEqualToLength(mixed $value, float|int $length): void
    {
        $assertion = new LessThanOrEqualTo($value, $length);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be less or equal to $length characters"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueNotLessThanOrEqualToLengthAndCustomMessage(
        mixed $value,
        float|int $length,
        string $message
    ): void {
        $assertion = new LessThanOrEqualTo($value, $length);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotLessThanOrEqualToLengthWithCustomMessage(
        mixed $value,
        float|int $length,
        string $message
    ): void {
        $assertion = new LessThanOrEqualTo($value, $length);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
