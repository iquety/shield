<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\NotContains;
use Tests\TestCase;

class NotContainsTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['$'] = ['@Coração!#', '$'];
        $list['@Cr'] = ['@Coração!#', '@Cr'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(mixed $value, string $needle): void
    {
        $assertion = new NotContains($value, $needle);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['@'] = ['@Coração!#', '@'];
        $list['@C'] = ['@Coração!#', '@C'];
        $list['@Cora'] = ['@Coração!#', '@Cora'];
        $list['ç'] = ['@Coração!#', 'ç'];
        $list['çã'] = ['@Coração!#', 'çã'];
        $list['ção'] = ['@Coração!#', 'ção'];
        $list['ção!'] = ['@Coração!#', 'ção!'];
        $list['ção!#'] = ['@Coração!#', 'ção!#'];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(mixed $value, string $needle): void
    {
        $assertion = new NotContains($value, $needle);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must not contain $needle",
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value, string $needle): void
    {
        $assertion = new NotContains($value, $needle);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must not contain $needle"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(mixed $value, string $needle): void
    {
        $assertion = new NotContains($value, $needle);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $value está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(mixed $value, string $needle): void
    {
        $assertion = new NotContains($value, $needle);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $value está errado");
    }
}
