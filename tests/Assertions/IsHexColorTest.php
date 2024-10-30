<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsHexColor;
use Tests\TestCase;

class IsHexColorTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['HexColor 1'] = ['#123456'];
        $list['HexColor 2'] = ['#ABCDEF'];
        $list['HexColor 3'] = ['#012345'];
        $list['HexColor 4'] = ['#FEDCBA'];
        $list['HexColor 5'] = ['#987654'];
        $list['HexColor 6'] = ['#3210AB'];
        $list['HexColor 7'] = ['#CDEF01'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $text): void
    {
        $assertion = new IsHexColor($text);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['Invalid HexColor 1'] = ['#12345G'];
        $list['Invalid HexColor 2'] = ['#ABCDEFG'];
        $list['Invalid HexColor 3'] = ['#0123456'];
        $list['Invalid HexColor 4'] = ['#ABCDEF0'];
        $list['Invalid HexColor 5'] = ['#1234567'];
        $list['Invalid HexColor 6'] = ['#ABCDEF01'];
        $list['Invalid HexColor 7'] = ['#12345678'];
        $list['Invalid HexColor 8'] = ['#ABCDEF012'];
        $list['Invalid HexColor 9'] = ['#123456789'];
        $list['Invalid HexColor 10'] = ['#ABCDEF0123'];
        $list['Invalid HexColor 11'] = ['#123456789A'];
        $list['Invalid HexColor 12'] = ['#ABCDEF01234'];
        $list['Invalid HexColor 13'] = ['#123456789AB'];
        $list['Invalid HexColor 14'] = ['#ABCDEF012345'];
        $list['Invalid HexColor 15'] = ['#123456789ABC'];
        $list['Invalid HexColor 16'] = ['#ABCDEF0123456'];
        $list['Invalid HexColor 17'] = ['#123456789ABCD'];
        $list['Invalid HexColor 18'] = ['#ABCDEF01234567'];
        $list['Invalid HexColor 19'] = ['#123456789ABCDEF'];
        $list['Invalid HexColor 20'] = ['#ABCDEF012345678'];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(string $text): void
    {
        $assertion = new IsHexColor($text);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid hexadecimal color"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(string $text): void
    {
        $assertion = new IsHexColor($text);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid hexadecimal color"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $text): void
    {
        $assertion = new IsHexColor($text);

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
        $assertion = new IsHexColor($text);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $text está errado");
    }
}
