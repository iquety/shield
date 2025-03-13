<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayObject;
use Iquety\Shield\Assertion\IsFalse;
use stdClass;

class IsFalseTest extends AssertionCase
{

    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['boolean false']       = [false];
        $list['string false']        = ['false'];
        $list['binary false']        = [0];
        $list['string binary false'] = ['0'];
        $list['empty string']        = [''];
        $list['one space string']    = [' '];
        $list['two spaces string']   = ['  '];

        return $list;
    }
    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsFalse(mixed $value): void
    {
        $assertion = new IsFalse($value);

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

        $list['boolean true']       = $this->makeIncorrectItem(true);
        $list['string true']        = $this->makeIncorrectItem('true');
        $list['binary true']        = $this->makeIncorrectItem(1);
        $list['string binary true'] = $this->makeIncorrectItem('1');
        $list['string']             = $this->makeIncorrectItem('x');
        $list['empty array']        = $this->makeIncorrectItem([]);
        $list['object']             = $this->makeIncorrectItem(new stdClass());
        $list['countable']          = $this->makeIncorrectItem(new ArrayObject());
        $list['null']               = $this->makeIncorrectItem(null);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotFalse(mixed $value): void
    {
        $assertion = new IsFalse($value);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be false"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotFalse(mixed $value): void
    {
        $assertion = new IsFalse($value);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be false"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotFalseWithCustomMessage(
        mixed $value,
        string $message
    ): void {
        $assertion = new IsFalse($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotFalseWithCustomMessage(mixed $value, string $message): void
    {
        $assertion = new IsFalse($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
