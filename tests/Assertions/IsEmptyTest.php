<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayObject;
use Iquety\Shield\Assertion\IsEmpty;
use stdClass;

class IsEmptyTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['empty string']      = [''];
        $list['one space string']  = [' '];
        $list['two spaces string'] = ['  '];
        $list['null']              = [null];
        $list['int']               = [0];
        $list['float']             = [0.0];
        $list['array']             = [[]];
        $list['boolean'] = [false];
        $list['empty countable']   = [new ArrayObject()];

        // não contável é considerado vazio
        $list['uncontable'] = [new stdClass()];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsEmpty(mixed $value): void
    {
        $assertion = new IsEmpty($value);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value): array
    {
        $messageValue = $this->makeMessageValue($value);

        return [
            $value,
            "O valor $messageValue está errado" // mensagem personalizada
        ];
    }

    /** @return array<string,array<int,mixed>> */
    public function invalidProvider(): array
    {
        $list = [];

        $list['string']    = $this->makeIncorrectItem('x');
        $list['int']       = $this->makeIncorrectItem(1);
        $list['float']     = $this->makeIncorrectItem(1.0);
        $list['array']     = $this->makeIncorrectItem(['x']);
        $list['boolean']   = $this->makeIncorrectItem(true);
        $list['countable'] = $this->makeIncorrectItem(new ArrayObject(['value']));

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotEmpty(mixed $value): void
    {
        $assertion = new IsEmpty($value);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be empty"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotEmpty(mixed $value): void
    {
        $assertion = new IsEmpty($value);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be empty"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotEmptyWithCustomMessage(mixed $value, string $message): void
    {
        $assertion = new IsEmpty($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotEmptyWithCustomMessage(mixed $value, string $message): void
    {
        $assertion = new IsEmpty($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
