<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\NotMatches;
use Tests\TestCase;

class NotMatchesTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list[] = ['Coração de Leão', '/orax/'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $value, string $pattern): void
    {
        $assertion = new NotMatches($value, $pattern);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,array<int,string>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list[] = ['Coração de Leão', '/oraç/'];
        $list[] = ['123-456-7890', '/(\d{3})-(\d{3})-(\d{4})/'];
        $list[] = ['Hello World', '/World/'];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(mixed $value, string $pattern): void
    {
        $assertion = new NotMatches($value, $pattern);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must not match $pattern",
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value, string $pattern): void
    {
        $assertion = new NotMatches($value, $pattern);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must not match $pattern"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(mixed $value, string $pattern): void
    {
        $assertion = new NotMatches($value, $pattern);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $value está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(mixed $value, string $pattern): void
    {
        $assertion = new NotMatches($value, $pattern);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $value está errado");
    }
}
