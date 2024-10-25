<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsNotEmpty;
use Tests\TestCase;

class IsNotEmptyTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function notEmptyValuesProvider(): array
    {
        $list = [];

        $list['string'] = ['x'];
        $list['int'] = [1];
        $list['float'] = [1.0];
        $list['array'] = [['x']];

        return $list;
    }

    /**
     * @test
     * @dataProvider notEmptyValuesProvider
     */
    public function assertedCase(mixed $value): void
    {
        $assertion = new IsNotEmpty($value);

        $this->assertTrue($assertion->isValid());
    }


    /** @return array<string,array<int,mixed>> */
    public function emptyValuesProvider(): array
    {
        $list = [];

        $list['string'] = ['', ''];
        $list['null'] = [null, 'null'];
        $list['int'] = [0, '0'];
        $list['float'] = [0.0, '0'];
        $list['array'] = [[], '[]'];

        return $list;
    }

    /**
     * @test
     * @dataProvider emptyValuesProvider
     */
    public function notAssertedCase(mixed $value): void
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
     * @dataProvider emptyValuesProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value): void
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
     * @dataProvider emptyValuesProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(mixed $value, string $valueString): void
    {
        $assertion = new IsNotEmpty($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $valueString está errado");
    }

    /**
     * @test
     * @dataProvider emptyValuesProvider
     */
    public function notAssertedCaseWithCustomMessage(mixed $value, string $valueString): void
    {
        $assertion = new IsNotEmpty($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $valueString está errado");
    }
}
