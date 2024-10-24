<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Shield\Assertion\IsTrue;
use Tests\TestCase;

class IsTrueTest extends TestCase
{
    /** @test */
    public function assertedCase(): void
    {
        $assertion = new IsTrue(true);

        $this->assertTrue($assertion->isValid());
    }

    /** @test */
    public function notAssertedCase(): void
    {
        $assertion = new IsTrue(false);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be true"
        );
    }

    /** @test */
    public function notAssertedCaseWithNamedAssertion(): void
    {
        $assertion = new IsTrue(false);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be true"
        );
    }

    /** @test */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(): void
    {
        $assertion = new IsTrue(false);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor false está errado");
    }

    /** @test */
    public function notAssertedCaseWithCustomMessage(): void
    {
        $assertion = new IsTrue(false);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor false está errado");
    }
}
