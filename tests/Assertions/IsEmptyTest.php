<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsEmpty;
use Tests\TestCase;

class IsEmptyTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function emptyValuesProvider(): array
    {
        $list = [];

        $list['string'] = [''];
        $list['null'] = [null];
        $list['int'] = [0];
        $list['float'] = [0.0];
        $list['array'] = [[]];

        return $list;
    }

    /**
     * @test
     * @dataProvider emptyValuesProvider
     */
    public function assertedCase(mixed $value): void
    {
        $assertion = new IsEmpty($value);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function notEmptyValuesProvider(): array
    {
        $list = [];

        $list['string'] = ['x', 'x'];
        $list['int'] = [1, '1'];
        $list['float'] = [1.0, '1'];
        $list['array'] = [['x'], '["x"]'];

        return $list;
    }

    /**
     * @test
     * @dataProvider notEmptyValuesProvider
     */
    public function notAssertedCase(mixed $value): void
    {
        $assertion = new IsEmpty($value);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be empty"
        );
    }

    /**
     * @test
     * @dataProvider notEmptyValuesProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value): void
    {
        $assertion = new IsEmpty($value);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be empty"
        );
    }

    /**
     * @test
     * @dataProvider notEmptyValuesProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(mixed $value, string $valueString): void
    {
        $assertion = new IsEmpty($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $valueString está errado");
    }

    /**
     * @test
     * @dataProvider notEmptyValuesProvider
     */
    public function notAssertedCaseWithCustomMessage(mixed $value, string $valueString): void
    {
        $assertion = new IsEmpty($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $valueString está errado");
    }
}
