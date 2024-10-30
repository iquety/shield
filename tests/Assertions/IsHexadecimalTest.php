<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsHexadecimal;
use Tests\TestCase;

class IsHexadecimalTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['Valid Hexadecimal 1'] = ['1234567890abcdef'];
        $list['Valid Hexadecimal 2'] = ['ABCDEF0123456789'];
        $list['Valid Hexadecimal 3'] = ['0123456789abcdefABCDEF'];
        $list['Valid Hexadecimal 4'] = ['0123456789ABCDEFabcdef'];
        $list['Valid Hexadecimal 5'] = ['1234567890ABCDEFabcdef0'];
        $list['Valid Hexadecimal 6'] = ['0123456789abcdefABCDEF0'];
        $list['Valid Hexadecimal 7'] = ['1234567890ABCDEFabcdef0123456789abcdef'];
        $list['Valid Hexadecimal 8'] = ['0123456789abcdefABCDEF0123456789abcdef'];
        $list['Valid Hexadecimal 9'] = ['1234567890ABCDEFabcdef0123456789ABCDEF'];
        $list['Valid Hexadecimal 10'] = ['0123456789abcdefABCDEF0123456789ABCDEF'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $text): void
    {
        $assertion = new IsHexadecimal($text);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['Invalid Hexadecimal 1'] = ['1234567890g'];
        $list['Invalid Hexadecimal 2'] = ['ABCDEF012345678G'];
        $list['Invalid Hexadecimal 3'] = ['0123456789abcdefG'];
        $list['Invalid Hexadecimal 4'] = ['0123456789ABCDEFg'];
        $list['Invalid Hexadecimal 5'] = ['1234567890ABCDEFabcdefg'];
        $list['Invalid Hexadecimal 6'] = ['0123456789abcdefABCDEFg'];
        $list['Invalid Hexadecimal 7'] = ['1234567890ABCDEFabcdefg123456789abcdef'];
        $list['Invalid Hexadecimal 8'] = ['0123456789abcdefABCDEFg123456789abcdef'];
        $list['Invalid Hexadecimal 9'] = ['1234567890ABCDEFabcdefg123456789ABCDEF'];
        $list['Invalid Hexadecimal 10'] = ['0123456789abcdefABCDEFg123456789ABCDEF'];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(string $text): void
    {
        $assertion = new IsHexadecimal($text);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid hexadecimal number"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(string $text): void
    {
        $assertion = new IsHexadecimal($text);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid hexadecimal number"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $text): void
    {
        $assertion = new IsHexadecimal($text);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $text está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(string $text): void
    {
        $assertion = new IsHexadecimal($text);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $text está errado");
    }
}
