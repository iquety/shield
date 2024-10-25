<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsEmail;
use Tests\TestCase;

class IsEmailTest extends TestCase
{
    /** @test */
    public function assertedCase(): void
    {
        $assertion = new IsEmail('teste@teste.com');

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,array<int,string>> */
    public function invalidEmailsProvider(): array
    {
        $list = [];

        $list[] = [ 'testeteste.com' ];

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidEmailsProvider
     */
    public function notAssertedCase(string $email): void
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
     * @dataProvider invalidEmailsProvider
     */
    public function notAssertCaseWithNamedAssertion(string $email): void
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
     * @dataProvider invalidEmailsProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $email): void
    {
        $assertion = new IsEmail($email);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $email está errado");
    }

    /**
     * @test
     * @dataProvider invalidEmailsProvider
     */
    public function notAssertedCaseWithCustomMessage(string $email): void
    {
        $assertion = new IsEmail($email);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $email está errado");
    }
}
