<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsAlpha;
use Tests\TestCase;

class IsAlphaTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['Text 1'] = ['TEXTO'];
        $list['Text 2'] = ['abc'];
        $list['Text 3'] = ['xyz'];
        $list['Text 4'] = ['TextoABC'];
        $list['Text 5'] = ['XYZTexto'];
        $list['Text 6'] = ['TextoXYZ'];
        $list['Text 7'] = ['TextoABC'];
        $list['Text 8'] = ['abcxyz'];
        $list['Text 9'] = ['AbCxYz'];
        $list['Text 10'] = ['texto'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $text): void
    {
        $assertion = new IsAlpha($text);

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
    public function notAssertedCase(string $text): void
    {
        $assertion = new IsAlpha($text);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must contain only letters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(string $text): void
    {
        $assertion = new IsAlpha($text);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must contain only letters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $text): void
    {
        $assertion = new IsAlpha($text);

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
        $assertion = new IsAlpha($text);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $text está errado");
    }
}
