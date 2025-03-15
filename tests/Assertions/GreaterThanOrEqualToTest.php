<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
use ArrayObject;
use Iquety\Shield\Assertion\GreaterThanOrEqualTo;
use stdClass;

class GreaterThanOrEqualToTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['string 7 chars is greater than or equal to 7'] = ['Palavra', 7];
        $list['string 7 chars is greater than or equal to 6'] = ['Palavra', 6];

        $list['string utf8 7 chars is greater than or equal to 7'] = ['coração', 7];
        $list['string utf8 7 chars is greater than or equal to 6'] = ['coração', 6];

        $list['integer 9 is greater than or equal to 9'] = [9, 9];
        $list['integer 9 is greater than or equal to 8'] = [9, 8];

        $list['float 9.9 is greater than or equal to 9.9'] = [9.9, 9.9];
        $list['float 9.9 is greater than or equal to 9.0'] = [9.9, 9.0];

        $list['float 9.8 is greater than or equal to integer 9.8'] = [9.8, 9.8];
        $list['float 9.8 is greater than or equal to integer 9'] = [9.8, 9];

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements is greater than or equal 7'] = [$arrayValue, 7];
        $list['array with 7 elements is greater than or equal 6'] = [$arrayValue, 6];

        $list['countable with 7 elements is greater or equal than 7'] = [new ArrayObject($arrayValue), 7];
        $list['countable with 7 elements is greater or equal than 6'] = [new ArrayObject($arrayValue), 6];

        $list['countable iterator with 7 elements is greater or equal than 7'] = [new ArrayIterator($arrayValue), 7];
        $list['countable iterator with 7 elements is greater or equal than 6'] = [new ArrayIterator($arrayValue), 6];

        $stdObject        = new stdClass();
        $stdObject->one   = 'Meu';
        $stdObject->two   = 'Texto';
        $stdObject->three = 'Legal';
        $list['stdClass with 3 public properties is greater than or equal 3'] = [$stdObject, 3];
        $list['stdClass with 3 public properties is greater than or equal 2'] = [$stdObject, 2];

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

        $list['string']           = $this->makeIncorrectItem('Palavra', 10);
        $list['string utf8']      = $this->makeIncorrectItem('coração', 10); // exatamente 7 caracteres
        $list['int']              = $this->makeIncorrectItem(9, 10);
        $list['float']            = $this->makeIncorrectItem(9.9, 10.0);
        $list['float + int']      = $this->makeIncorrectItem(9.8, 10);
        $list['array less']       = $this->makeIncorrectItem([1, 2, 3], 4);
        
        $list['countable with 3 elements is not greater than or equal to 4'] = $this->makeIncorrectItem(new ArrayObject(['a', 'b', 'c']), 4);

        $list['countable iterator with 3 elements is not greater than or equal to 4'] = $this->makeIncorrectItem(new ArrayIterator(['a', 'b', 'c']), 4);

        $stdObject        = new stdClass();
        $stdObject->one   = 'Meu';
        $stdObject->two   = 'Texto';
        $stdObject->three = 'Legal';
        $list['stdClass with 3 public properties is not greater than or equal to 4'] = $this->makeIncorrectItem($stdObject, 4);

        $list['null is invalid']  = $this->makeIncorrectItem(null, 0);
        $list['false is invalid'] = $this->makeIncorrectItem(false, 0);
        $list['true is invalid']  = $this->makeIncorrectItem(true, 0);

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
