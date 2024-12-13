<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsCep;
use Tests\TestCase;

class IsCepTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        return [
            'Valid CEP - format 1' => ['12345-678'],
            'Valid CEP - format 2' => ['98765-432'],
            'Valid CEP - format 3' => ['01000-000'],
            'Valid CEP - format 4' => ['99999-999'],
            'Valid CEP - format 5' => [12345678],
            'Valid CEP - format 6' => [98765432],
            'Valid CEP - format 7' => [11000000],
            'Valid CEP - format 8' => [99999999],
        ];
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueIsCep(int|string $cepCode): void
    {
        $assertion = new IsCep($cepCode);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        return [
            'Invalid CEP - too short' => ['1234-567'],
            'Invalid CEP - too long' => ['123456-789'],
            'Invalid CEP - invalid characters' => ['12A45-678'],
            'Invalid CEP - missing separator' => ['12345678'],
            'Invalid CEP - empty string' => [''],
            'Invalid CEP - spaces' => ['123 45-678'],
            'Invalid CEP - special characters' => ['123@5-678'],
            'Invalid CEP - many numbers' => [123567890],
            'Invalid CEP - loss numbers' => [123567],
        ];
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotCep(int|string $cepCode): void
    {
        $assertion = new IsCep($cepCode);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid CEP"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotCep(int|string $cepCode): void
    {
        $assertion = new IsCep($cepCode);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid CEP"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotCepAndCustomMessage(int|string $cepCode): void
    {
        $assertion = new IsCep($cepCode);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $cepCode está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotCepWithCustomMessage(int|string $cepCode): void
    {
        $assertion = new IsCep($cepCode);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $cepCode está errado");
    }
}
