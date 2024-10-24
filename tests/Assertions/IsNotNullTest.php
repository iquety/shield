<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Shield\Assertion\IsNotNull;
use Tests\TestCase;

class IsNotNullTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function notNullValuesProvider(): array
    {
        $list = [];

        $list['string'] = ['x'];
        $list['int'] = [1];
        $list['float'] = [1.0];
        $list['array'] = [['x']];

        $list['empty string'] = [''];
        $list['empty int'] = [0];
        $list['empty float'] = [0.0];
        $list['empty array'] = [[]];

        return $list;
    }

    /**
     * @test
     * @dataProvider notNullValuesProvider
     */
    public function assertedCase(mixed $value): void
    {
        $assertion = new IsNotNull($value);

        $this->assertTrue($assertion->isValid());
    }


    /** @test */
    public function notAssertedCase(): void
    {
        $assertion = new IsNotNull(null);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must not be null"
        );
    }

    /** @test */
    public function notAssertedCaseWithNamedAssertion(): void
    {
        $assertion = new IsNotNull(null);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must not be null"
        );
    }

    /** @test */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(): void
    {
        $assertion = new IsNotNull(null);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor null está errado");
    }

    /** @test */
    public function notAssertedCaseWithCustomMessage(): void
    {
        $assertion = new IsNotNull(null);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor null está errado");
    }
}
