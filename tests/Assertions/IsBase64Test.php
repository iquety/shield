<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsBase64;
use Tests\TestCase;

class IsBase64Test extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['Base64 Text 1'] = [base64_encode('Texto123')];
        $list['Base64 Text 2'] = [base64_encode('abc123')];
        $list['Base64 Text 3'] = [base64_encode('123xyz')];
        $list['Base64 Text 4'] = [base64_encode('TextoABC123')];
        $list['Base64 Text 5'] = [base64_encode('123XYZTexto')];
        $list['Base64 Text 6'] = [base64_encode('Texto123XYZ')];
        $list['Base64 Text 7'] = [base64_encode('TextoABC')];
        $list['Base64 Text 8'] = [base64_encode('abc123xyz')];
        $list['Base64 Text 9'] = [base64_encode('123')];
        $list['Base64 Text 10'] = [base64_encode('texto')];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $text): void
    {
        $assertion = new IsBase64($text);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['Not Base64 Text 1'] = ['Te&xto123'];
        $list['Not Base64 Text 2'] = ['abçc123='];
        $list['Not Base64 Text 3'] = ['12á3xyz='];
        $list['Not Base64 Text 4'] = ['Te^xtoABC123='];
        $list['Not Base64 Text 5'] = ['123*XYZTexto='];
        $list['Not Base64 Text 6'] = ['Text)o123XYZ='];
        $list['Not Base64 Text 7'] = ['Tex(toABC='];
        $list['Not Base64 Text 8'] = ['ab@c123xyz='];
        $list['Not Base64 Text 9'] = ['13#23='];
        $list['Not Base64 Text 10'] = ['t$exto='];
        $list['Not Base64 Text 11'] = ['%+'];
        $list['Not Base64 Text 12'] = ['&/'];
        $list['Not Base64 Text 13'] = ['_='];
        $list['Not Base64 Text 14'] = ['&=+=='];
        $list['Not Base64 Text 15'] = ['&+/='];
        $list['Not Base64 Text 16'] = ['&+/=='];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(string $text): void
    {
        $assertion = new IsBase64($text);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid base64 string"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(string $text): void
    {
        $assertion = new IsBase64($text);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid base64 string"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $text): void
    {
        $assertion = new IsBase64($text);

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
        $assertion = new IsBase64($text);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $text está errado");
    }
}
