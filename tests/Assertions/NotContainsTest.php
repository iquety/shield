<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\NotContains;
use stdClass;

class NotContainsTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string @Coração!# not contains $'] = ['@Coração!#', '$'];
        $list['string @Coração!# not contains @Cr'] = ['@Coração!#', '@Cr'];

        $arrayValue = [
            111,    // inteiro
            '222',  // inteiro string
            22.5,   // decimal
            '11.5', // decimal string
            'ção!#' // string
        ];

        $list['array not contains string 111'] = [$arrayValue, '111'];
        $list['array not contains inteiro 222'] = [$arrayValue, 222];
        $list['array not contains string 22.5'] = [$arrayValue, '22.5'];
        $list['array not contains decimal 11.5'] = [$arrayValue, 11.5];
        $list['array not contains string $'] = [$arrayValue, '$'];
        $list['array not contains string @Cr'] = [$arrayValue, '@Cr'];

        $list['object not valid'] = [new stdClass(), ''];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueNotContainsNeedle(mixed $value, float|int|string $needle): void
    {
        $assertion = new NotContains($value, $needle);

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

        $list['string contains @Cora'] = $this->makeIncorrectItem('@Coração!#', '@Co');
        $list['string contains ção'] = $this->makeIncorrectItem('@Coração!#', 'ra');
        $list['string contains ção!#'] = $this->makeIncorrectItem('@Coração!#', 'ção!#');

        $valueArray = [
            111,    // inteiro
            '222',  // inteiro string
            22.5,   // decimal
            '11.5', // decimal string
            'ção!#' // string
        ];

        $list['array contains integer 111'] = $this->makeIncorrectItem($valueArray, 111);
        $list['array contains string 222'] = $this->makeIncorrectItem($valueArray, '222');
        $list['array contains decimal 22.5'] = $this->makeIncorrectItem($valueArray, 22.5);
        $list['array contains string 11.5'] = $this->makeIncorrectItem($valueArray, '11.5');
        $list['array contains string'] = $this->makeIncorrectItem($valueArray, 'ção!#');

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueContainsNeedle(mixed $value, float|int|string $needle): void
    {
        $assertion = new NotContains($value, $needle);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must not contain $needle",
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueContainsNeedle(mixed $value, float|int|string $needle): void
    {
        $assertion = new NotContains($value, $needle);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must not contain $needle"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueContainsNeedleAndCustomMessage(
        mixed $value,
        float|int|string $needle,
        string $message
    ): void {
        $assertion = new NotContains($value, $needle);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueContainsNeedleWithCustomMessage(
        mixed $value,
        float|int|string $needle,
        string $message
    ): void {
        $assertion = new NotContains($value, $needle);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
