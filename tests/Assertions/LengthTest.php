<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayIterator;
use ArrayObject;
use Iquety\Shield\Assertion\Length;
use stdClass;

class LengthTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['string 7 chars has length 7']      = ['Palavra', 7];
        $list['string utf8 7 chars has length 7'] = ['coração', 7];

        $list['integer 9 has length 9']   = [9, 9];
        $list['float 9.9 has length 9.9'] = [9.9, 9.9];

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements has length 7'] = [$arrayValue, 7];

        $list['countable with 7 elements has length 7'] = [new ArrayObject($arrayValue), 7];

        $list['countable iterator with 7 elements is length 7'] = [new ArrayIterator($arrayValue), 7];

        $stdObject        = new stdClass();
        $stdObject->one   = 'Meu';
        $stdObject->two   = 'Texto';
        $stdObject->three = 'Legal';
        $list['stdClass with 3 public properties is lenght 3'] = [$stdObject, 3];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueHasLength(mixed $value, float|int $length): void
    {
        $assertion = new Length($value, $length);

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

        $list['string 7 chars has not length 8'] = $this->makeIncorrectItem('Palavra', 8);
        $list['string 7 chars has not length 6'] = $this->makeIncorrectItem('Palavra', 6);

        $list['string utf8 7 chars has not length 8'] = $this->makeIncorrectItem('coração', 8);
        $list['string utf8 7 chars has not length 6'] = $this->makeIncorrectItem('coração', 6);

        $list['integer 9 has not length 10'] = $this->makeIncorrectItem(9, 10);
        $list['integer 9 has not length 8']  = $this->makeIncorrectItem(9, 8);

        $list['float 9.9 has not length 10.1'] = $this->makeIncorrectItem(9.9, 10.1);
        $list['float 9.9 has not length 9.8']  = $this->makeIncorrectItem(9.9, 9.8);

        $arrayValue = [1, 2, 3, 4, 5, 6, 7];

        $list['array with 7 elements has not length 8'] = $this->makeIncorrectItem($arrayValue, 8);
        $list['array with 7 elements has not length 6'] = $this->makeIncorrectItem($arrayValue, 6);

        $list['countable with 7 elements has length 8'] = $this->makeIncorrectItem(new ArrayObject($arrayValue), 8);
        $list['countable with 7 elements has length 6'] = $this->makeIncorrectItem(new ArrayObject($arrayValue), 6);

        $list['countable iterator with 7 elements has length 8']
            = $this->makeIncorrectItem(new ArrayIterator($arrayValue), 8);

        $list['countable iterator with 7 elements has length 6']
            = $this->makeIncorrectItem(new ArrayIterator($arrayValue), 6);

        $stdObject        = new stdClass();
        $stdObject->one   = 'Meu';
        $stdObject->two   = 'Texto';
        $stdObject->three = 'Legal';
        $list['stdClass with 3 public properties is lenght 4'] = $this->makeIncorrectItem($stdObject, 4);
        $list['stdClass with 3 public properties is lenght 2'] = $this->makeIncorrectItem($stdObject, 2);

        $list['null is invalid']  = $this->makeIncorrectItem(null, 0);
        $list['false is invalid'] = $this->makeIncorrectItem(false, 0);
        $list['true is invalid']  = $this->makeIncorrectItem(true, 0);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotHasLength(mixed $value, float|int $length): void
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
    public function namedValueNotHasLength(mixed $value, float|int $length): void
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
        float|int $length,
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
        float|int $length,
        string $message
    ): void {
        $assertion = new Length($value, $length);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
