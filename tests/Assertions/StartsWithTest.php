<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\StartsWith;
use Tests\TestCase;

class StartsWithTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string starts with @'] = ['@Coração!#', '@'];

        $arrayStartStringInt = ['123', 123, '12.5', 12.5, 'ção!#'];
        $list['array starts with string integer 123'] = [$arrayStartStringInt, '123'];

        $arrayStartInt = [123, '123', '12.5', 12.5, 'ção!#'];
        $list['array starts with integer 123'] = [$arrayStartInt, 123];

        $arrayStartStrFloat = ['12.5', 12.5, 123, '123', 'ção!#'];
        $list['array starts with string float 12.5'] = [$arrayStartStrFloat, '12.5'];

        $arrayStartFloat = [12.5, '12.5', 123, '123', 'ção!#'];
        $list['array starts with string float 12.5'] = [$arrayStartFloat, 12.5];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(mixed $value, mixed $partial): void
    {
        $assertion = new StartsWith($value, $partial);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string not start with $'] = ['@Coração!#', '$', "O valor @Coração!# está errado"];
        $list['string not start with @Cr'] = ['@Coração!#', '@Cr', "O valor @Coração!# está errado"];

        $array = ['123', 123, '12.5', 12.5, 'ção!#'];
        $string = str_replace([':', '{', '}'], ['=>', '[', ']'], (string)json_encode($array));

        $list['array not start with string 12.5'] = [$array, '12.5', "O valor $string está errado"];
        $list['array not start with integer 123'] = [$array, 123, "O valor $string está errado"];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(mixed $value, float|int|string $needle): void
    {
        $assertion = new StartsWith($value, $needle);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must start with '$needle'"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(mixed $value, float|int|string $needle): void
    {
        $assertion = new StartsWith($value, $needle);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must start with '$needle'"
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
        $assertion = new StartsWith($value, $needle);

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
        $assertion = new StartsWith($value, $needle);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
