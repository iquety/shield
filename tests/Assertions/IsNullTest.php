<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsNull;

class IsNullTest extends AssertionCase
{
    /** @return array<string,array<mixed>> */
    public function emptyProvider(): array
    {
        return [
            'empty string'  => [''],
            'empty array'   => [[]],
        ];
    }

    /**
     * @test
     * @dataProvider emptyProvider
     */
    public function valueIsEmpty(mixed $value): void
    {
        $assertion = new IsNull($value);

        $this->assertTrue($assertion->isValid());
    }

    /** @test */
    public function valueIsNull(): void
    {
        $assertion = new IsNull(null);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function invalidProvider(): array
    {
        $list = [];

        $list['bool']         = $this->makeIncorrectItem(true);
        $list['false']        = $this->makeIncorrectItem(false);
        $list['string']       = $this->makeIncorrectItem('x');
        $list['int']          = $this->makeIncorrectItem(1);
        $list['float']        = $this->makeIncorrectItem(1.0);
        $list['array']        = $this->makeIncorrectItem(['x']);
        $list['empty int']    = $this->makeIncorrectItem(0);
        $list['empty float']  = $this->makeIncorrectItem(0.0);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotNull(mixed $value): void
    {
        $assertion = new IsNull($value);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            'Value must be null'
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotNull(mixed $value): void
    {
        $assertion = new IsNull($value);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be null"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotNullWithCustomMessage(
        mixed $value,
        string $message
    ): void {
        $assertion = new IsNull($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotNullWithCustomMessage(
        mixed $value,
        string $message
    ): void {
        $assertion = new IsNull($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
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
}
