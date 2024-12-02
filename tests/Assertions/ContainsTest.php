<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\Contains;

class ContainsTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string contains @Cora'] = ['@Coração!#', '@Co'];
        $list['string contains ção'] = ['@Coração!#', 'ra'];
        $list['string contains ção!#'] = ['@Coração!#', 'ção!#'];

        $valueArray = [
            111,    // inteiro
            '222',  // inteiro string
            22.5,   // decimal
            '11.5', // decimal string
            'ção!#' // string
        ];

        $list['array contains integer 111'] = [$valueArray, 111];
        $list['array contains string 222'] = [$valueArray, '222'];
        $list['array contains decimal 22.5'] = [$valueArray, 22.5];
        $list['array contains string 11.5'] = [$valueArray, '11.5'];
        $list['array contains string'] = [$valueArray, 'ção!#'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueContainsNeedle(mixed $value, float|int|string $needle): void
    {
        $assertion = new Contains($value, $needle);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value, mixed $partial): array
    {
        $messageValue = $this->makeMessageValue($value);

        return [
            $value,
            $partial,
            "O valor $messageValue está errado" // mensagem personalizada
        ];
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['string not contains $'] = $this->makeIncorrectItem('@Coração!#', '$');
        $list['string not contains @Cr'] = ['@Coração!#', '@Cr', "O valor @Coração!# está errado"];

        $arrayValue = [
            111,    // inteiro
            '222',  // inteiro string
            22.5,   // decimal
            '11.5', // decimal string
            'ção!#' // string
        ];

        $messageValue = $this->makeArrayMessage($arrayValue);

        $list['array not contains string 111'] = [$arrayValue, '111', "O valor $messageValue está errado"];

        $list['array not contains inteiro 222'] = [$arrayValue, 222, "O valor $messageValue está errado"];

        $list['array not contains string 22.5'] = [$arrayValue, '22.5', "O valor $messageValue está errado"];

        $list['array not contains decimal 11.5'] = [$arrayValue, 11.5, "O valor $messageValue está errado"];

        $list['array not contains string $'] = [$arrayValue, '$', "O valor $messageValue está errado"];

        $list['array not contains string @Cr'] = [$arrayValue, '@Cr', "O valor $messageValue está errado"];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueNotContainsNeedle(mixed $value, float|int|string $needle): void
    {
        $assertion = new Contains($value, $needle);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), "Value must contain $needle");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueNotContainsNeedle(mixed $value, float|int|string $needle): void
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
    public function namedValueNotContainsNeedleWithCustomMessage(
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
    public function valueNotContainsNeedleWithCustomMessage(
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
