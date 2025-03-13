<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsEmail;
use stdClass;

class IsEmailTest extends AssertionCase
{
    /** @test */
    public function valueIsEmail(): void
    {
        $assertion = new IsEmail('teste@teste.com');

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

    /** @return array<string,array<int,string>> */
    public function invalidProvider(): array
    {
        $list = [];

        $list['invalid']           = $this->makeIncorrectItem('testeteste.com');
        $list['empty string']      = $this->makeIncorrectItem('');
        $list['one space string']  = $this->makeIncorrectItem(' ');
        $list['two spaces string'] = $this->makeIncorrectItem('  ');
        $list['array']             = $this->makeIncorrectItem(['a']);
        $list['object']            = $this->makeIncorrectItem(new stdClass());
        $list['false']             = $this->makeIncorrectItem(false);
        $list['true']              = $this->makeIncorrectItem(true);
        $list['null']              = $this->makeIncorrectItem(null);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotEmail(mixed $email): void
    {
        $assertion = new IsEmail($email);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid email"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotEmail(mixed $email): void
    {
        $assertion = new IsEmail($email);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid email"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotEmailWithCustomMessage(
        mixed $email,
        string $message
    ): void {
        $assertion = new IsEmail($email);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotEmailWithCustomMessage(
        mixed $email,
        string $message
    ): void {
        $assertion = new IsEmail($email);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
