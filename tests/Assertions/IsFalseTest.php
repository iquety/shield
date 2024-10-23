<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Shield\Assertion\IsFalse;
use Tests\TestCase;

class IsFalseTest extends TestCase
{
    /** @test */
    public function assertedCase(): void
    {
        $assertion = new IsFalse(false);

        $this->assertTrue($assertion->isValid());
    }

    /** @test */
    public function notAssertedCase(): void
    {
        $assertion = new IsFalse(true);

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "The value is not false");
    }

    /** @test */
    public function notAssertCaseWithNamedAssertion(): void
    {
        $assertion = new IsFalse(true);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "The value of field 'name' is not false");
    }

    /** @test */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(): void
    {
        $assertion = new IsFalse(true);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor true está errado");
    }

    /** @test */
    public function notAssertedCaseWithCustomMessage(): void
    {
        $assertion = new IsFalse(true);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor true está errado");
    }
}
