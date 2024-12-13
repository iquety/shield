<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsAlphaNumeric;
use Tests\TestCase;

class IsAlphaNumericTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['Upper case string'] = ['CORAÇÃO'];
        $list['Lower case string'] = ['coração'];
        $list['Upper case string + integer'] = ['CORAÇÃO123'];
        $list['Lower case string + integer'] = ['coração123'];
        $list['string integer'] = ['123'];
        $list['string decimal'] = ['12.3'];
        $list['integer'] = [123];
        $list['decimal'] = [12.3];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueIsAlphaNumeric(float|int|string $alphaNumeric): void
    {
        $assertion = new IsAlphaNumeric($alphaNumeric);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        return [
            'ISO 8601 dirty' => ['00002024-12-31xxx'],
            'European format dirty' => ['31/12//2024'],
            'US format dirty' => ['xxx12/31/2024'],
            'Alternative format dirty' => ['rr2x024.12.31'],
            'Abbreviated month name dirty' => ['xxx31-Dec-2024'],
            'Full month name dirty' => ['xxxDecember 31, 2024'],
            'ISO 8601 invalid month' => ['2024-13-31'],
            'ISO 8601 invalid day' => ['2024-12-32'],
            'European format month' => ['31/13/2024'],
            'European format day' => ['32/12/2024'],
            'US format month' => ['13/31/2024'],
            'US format day' => ['12/32/2024'],
            'Alternative format month' => ['2024.13.31'],
            'Alternative format day' => ['2024.12.32'],
            'Abbreviated month name month' => ['31-Err-2024'],
            'Abbreviated month name day' => ['32-Dec-2024'],
            'Full month name month' => ['Invalid 31, 2024'],
            'Full month name day' => ['December 32, 2024'],
            'Special characters' => ['@#$%^&*()'],
            'Numbers and special characters' => ['123@#$%'],
            'Empty string' => [''],
        ];
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotAlphaNumeric(string $value): void
    {
        $assertion = new IsAlphaNumeric($value);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must contain only letters and numbers"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotAlphaNumeric(string $value): void
    {
        $assertion = new IsAlphaNumeric($value);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must contain only letters and numbers"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotAlphaNumericAndCustomMessage(string $value): void
    {
        $assertion = new IsAlphaNumeric($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $value está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotAlphaNumericWithCustomMessage(string $value): void
    {
        $assertion = new IsAlphaNumeric($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $value está errado");
    }
}
