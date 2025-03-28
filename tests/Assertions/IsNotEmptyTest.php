<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayObject;
use InvalidArgumentException;
use Iquety\Shield\Assertion\IsNotEmpty;
use stdClass;

class IsNotEmptyTest extends AssertionCase
{
    /** @test */
    public function valueIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value is not valid');

        $assertion = new IsNotEmpty(new stdClass());

        $assertion->isValid();
    }
    
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['string']        = ['x'];
        $list['int']           = [1];
        $list['float']         = [1.0];
        $list['array']         = [['x']];
        // $list['uncontable']    = [new stdClass()]; // não contável é vazio
        $list['boolean true']  = [true];
        // $list['boolean false'] = [false];          // false é vazio
        $list['countable']     = [new ArrayObject(['value'])];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsNotEmpty(mixed $value): void
    {
        $assertion = new IsNotEmpty($value);

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

        $list['empty string']      = $this->makeIncorrectItem('');
        $list['one space string']  = $this->makeIncorrectItem(' ');
        $list['two spaces string'] = $this->makeIncorrectItem('  ');
        $list['null']              = $this->makeIncorrectItem(null);
        $list['int']               = $this->makeIncorrectItem(0);
        $list['float']             = $this->makeIncorrectItem(0.0);
        $list['array']             = $this->makeIncorrectItem([]);
        $list['boolean']           = $this->makeIncorrectItem(false);
        $list['countable']         = $this->makeIncorrectItem(new ArrayObject());

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsEmpty(mixed $value): void
    {
        $assertion = new IsNotEmpty($value);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must not be empty"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsEmpty(mixed $value): void
    {
        $assertion = new IsNotEmpty($value);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must not be empty"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsEmptyWithCustomMessage(mixed $value, string $message): void
    {
        $assertion = new IsNotEmpty($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsEmptyWithCustomMessage(mixed $value, string $message): void
    {
        $assertion = new IsNotEmpty($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
