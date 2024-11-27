<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\EndsWith;
use Tests\TestCase;

class EndsWithTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string ends with !#'] = ['@Coração!#', '!#'];

        $arrayEndStringInt = ['12.5', 12.5, 'ção!#', 123, '123'];
        $list['array ends with string integer 123'] = [$arrayEndStringInt, '123'];

        $arrayEndInt = ['12.5', 12.5, 'ção!#', '123', 123];
        $list['array ends with integer 123'] = [$arrayEndInt, 123];

        $arrayEndStringFloat = [123, '123', 'ção!#', 12.5, '12.5'];
        $list['array ends with string float 12.5'] = [$arrayEndStringFloat, '12.5'];

        $arrayEndFloat = [123, '123', 'ção!#', '12.5', 12.5];
        $list['array ends with string float 12.5'] = [$arrayEndFloat, 12.5];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(mixed $value, mixed $partial): void
    {
        $assertion = new EndsWith($value, $partial);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string not end with $'] = ['@Coração!#', '$', "O valor @Coração!# está errado"];
        $list['string not end with @Cr'] = ['@Coração!#', '@Cr', "O valor @Coração!# está errado"];

        $array = ['12.5', 12.5, 'ção!#', 123, '123'];
        $string = str_replace([':', '{', '}'], ['=>', '[', ']'], (string)json_encode($array));

        $list['array not end with string 12.5'] = [$array, '12.5', "O valor $string está errado"];
        $list['array not end with integer 123'] = [$array, 123, "O valor $string está errado"];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(mixed $value, float|int|string $needle): void
    {
        $assertion = new EndsWith($value, $needle);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must end with '$needle'"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value, float|int|string $needle): void
    {
        $assertion = new EndsWith($value, $needle);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must end with '$needle'"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(
        mixed $value,
        float|int|string $needle,
        string $message
    ): void {
        $assertion = new EndsWith($value, $needle);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(
        mixed $value,
        float|int|string $needle,
        string $message
    ): void {
        $assertion = new EndsWith($value, $needle);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
