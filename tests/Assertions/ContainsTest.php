<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\Contains;
use Tests\TestCase;

class ContainsTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string contains @'] = ['@Coração!#', '@'];
        $list['string contains @C'] = ['@Coração!#', '@C'];
        $list['string contains @Cora'] = ['@Coração!#', '@Cora'];
        $list['string contains ç'] = ['@Coração!#', 'ç'];
        $list['string contains çã'] = ['@Coração!#', 'çã'];
        $list['string contains ção'] = ['@Coração!#', 'ção'];
        $list['string contains ção!'] = ['@Coração!#', 'ção!'];
        $list['string contains ção!#'] = ['@Coração!#', 'ção!#'];

        $array = ['123', 123, '12.5', 12.5, 'ção!#'];

        $list['array contains string 123'] = [$array, '123'];
        $list['array contains integer 123'] = [$array, 123];
        $list['array contains string 12.5'] = [$array, '12.5'];
        $list['array contains float 12.5'] = [$array, 12.5];
        $list['array contains ção!#'] = [$array, 'ção!#'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(mixed $value, float|int|string $needle): void
    {
        $assertion = new Contains($value, $needle);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string not contains $'] = ['@Coração!#', '$', "O valor @Coração!# está errado"];
        $list['string not contains @Cr'] = ['@Coração!#', '@Cr', "O valor @Coração!# está errado"];

        $array = [777, '999', '123', 123, '12.5', 12.5, 'ção!#'];
        $string = str_replace([':', '{', '}'], ['=>', '[', ']'], (string)json_encode($array));

        $list['array not contains $'] = [$array, '$', "O valor $string está errado"];
        $list['array not contains @Cr'] = [$array, '@Cr', "O valor $string está errado"];

        $list['array not contains string 777'] = [$array, '777', "O valor $string está errado"];
        $list['array not contains integer 999'] = [$array, 999, "O valor $string está errado"];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(mixed $value, float|int|string $needle): void
    {
        $assertion = new Contains($value, $needle);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must contain $needle",
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value, float|int|string $needle): void
    {
        $assertion = new Contains($value, $needle);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must contain $needle"
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
        $assertion = new Contains($value, $needle);

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
        $assertion = new Contains($value, $needle);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
