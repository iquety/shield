<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayObject;
use Iquety\Shield\Assertion\IsTrue;
use stdClass;

class IsTrueTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['boolean true']       = [true];
        $list['string true']        = ['true'];
        $list['binary true']        = [1];
        $list['string binary true'] = ['1'];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsTrue(mixed $value): void
    {
        $assertion = new IsTrue($value);

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

        $list['boolean false']       = $this->makeIncorrectItem(false);
        $list['string false']        = $this->makeIncorrectItem('false');
        $list['binary true']         = $this->makeIncorrectItem(0);
        $list['string binary false'] = $this->makeIncorrectItem('0');
        $list['empty string']        = $this->makeIncorrectItem('');
        $list['one space string']    = $this->makeIncorrectItem(' ');
        $list['two spaces string']   = $this->makeIncorrectItem('  ');
        $list['string']              = $this->makeIncorrectItem('x');
        $list['empty array']         = $this->makeIncorrectItem([]);
        $list['object']              = $this->makeIncorrectItem(new stdClass());
        $list['countable']           = $this->makeIncorrectItem(new ArrayObject());
        $list['null']                = $this->makeIncorrectItem(null);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotTrue(mixed $value): void
    {
        $assertion = new IsTrue($value);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be true"
        );
    }

    /**
     * @test 
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotTrue(mixed $value): void
    {
        $assertion = new IsTrue($value);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be true"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotTimeWithCustomMessage(
        mixed $value,
        string $message
    ): void {
        $assertion = new IsTrue($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test 
     * @dataProvider invalidProvider
     */
    public function valueIsNotTrueWithCustomMessage(
        mixed $value,
        string $message
    ): void {
        $assertion = new IsTrue($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
