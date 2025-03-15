<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayObject;
use Iquety\Shield\Assertion\IsNotNull;
use stdClass;

class IsNotNullTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['string'] = ['x'];
        $list['int'] = [1];
        $list['float'] = [1.0];
        $list['array'] = [['x']];

        $list['empty string']  = [''];
        $list['empty int']     = [0];
        $list['empty float']   = [0.0];
        $list['empty array']   = [[]];
        $list['boolean true']  = [true];
        $list['boolean false'] = [false];
        $list['countable']     = [new ArrayObject()];
        $list['uncontable']    = [new stdClass()];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsNotNull(mixed $value): void
    {
        $assertion = new IsNotNull($value);

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

        $list['null'] = $this->makeIncorrectItem(null);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNull(mixed $value): void
    {
        $assertion = new IsNotNull($value);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must not be null"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNull(mixed $value): void
    {
        $assertion = new IsNotNull($value);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must not be null"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function nameValueIsNullWithCustomMessage(
        mixed $value,
        string $message
    ): void {
        $assertion = new IsNotNull($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function notAssertedCaseWithCustomMessage(
        mixed $value,
        string $message
    ): void {
        $assertion = new IsNotNull($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
