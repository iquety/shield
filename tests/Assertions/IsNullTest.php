<?php

declare(strict_types=1);

namespace Tests;

use Iquety\Shield\Assertion\IsNull;
use Tests\TestCase;

class IsNullTest extends TestCase
{
    /** @test */
    public function assertedCase(): void
    {
        $assertion = new IsNull(null);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function notNullValuesProvider(): array
    {
        $list = [];

        $list['string'] = ['x', 'x'];
        $list['int'] = [1, '1'];
        $list['float'] = [1.0, '1'];
        $list['array'] = [['x'], '["x"]'];

        $list['empty string'] = ['', ''];
        $list['empty int'] = [0, '0'];
        $list['empty float'] = [0.0, '0'];
        $list['empty array'] = [[], '[]'];

        return $list;
    }

    /**
     * @test
     * @dataProvider notNullValuesProvider
     */
    public function notAssertedCase(mixed $value): void
    {
        $assertion = new IsNull($value);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be null"
        );
    }

    /**
     * @test
     * @dataProvider notNullValuesProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value): void
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
     * @dataProvider notNullValuesProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(mixed $value, string $valueString): void
    {
        $assertion = new IsNull($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $valueString está errado");
    }

    /**
     * @test
     * @dataProvider notNullValuesProvider
     */
    public function notAssertedCaseWithCustomMessage(mixed $value, string $valueString): void
    {
        $assertion = new IsNull($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $valueString está errado");
    }
}
