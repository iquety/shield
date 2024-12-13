<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\Contains;
use stdClass;

class ContainsTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string @Coração!# contains @Co'] = ['@Coração!#', '@Co'];
        $list['string @Coração!# contains ra'] = ['@Coração!#', 'ra'];
        $list['string @Coração!# contains ção!#'] = ['@Coração!#', 'ção!#'];

        $list['string 123456 contains string 123'] = ['123456', '123'];
        $list['string 123456 contains string 345'] = ['123456', '345'];
        $list['string 123456 contains string 456'] = ['123456', '456'];

        $list['string 123456 contains integer 123'] = ['123456', 123];
        $list['string 123456 contains integer 345'] = ['123456', 345];
        $list['string 123456 contains integer 456'] = ['123456', 456];

        $list['integer 123456 contains string 123'] = [123456, '123'];
        $list['integer 123456 contains string 345'] = [123456, '345'];
        $list['integer 123456 contains string 456'] = [123456, '456'];

        $list['integer 123456 contains integer 123'] = [123456, 123];
        $list['integer 123456 contains integer 345'] = [123456, 345];
        $list['integer 123456 contains integer 456'] = [123456, 456];

        //

        $list['string 12.3456 contains string 12.3'] = ['12.3456', '12.3'];
        $list['string 1234.56 contains string 34.5'] = ['1234.56', '34.5'];
        $list['string 12345.6 contains string 45.6'] = ['12345.6', '45.6'];

        $list['string 12.3456 contains decimal 12.3'] = ['12.3456', 12.3];
        $list['string 1234.56 contains decimal 34.5'] = ['1234.56', 34.5];
        $list['string 12345.6 contains decimal 45.6'] = ['12345.6', 45.6];

        $list['decimal 12.3456 contains string 12.3'] = [12.3456, '12.3'];
        $list['decimal 1234.56 contains string 34.5'] = [1234.56, '34.5'];
        $list['decimal 12345.6 contains string 45.6'] = [12345.6, '45.6'];

        $list['decimal 12.3456 contains decimal 12.3'] = [12.3456, 12.3];
        $list['decimal 1234.56 contains decimal 34.5'] = [1234.56, 34.5];
        $list['decimal 12345.6 contains decimal 45.6'] = [12345.6, 45.6];

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
        $messageValue = is_array($value) === true
            ? $this->makeArrayMessage($value)
            : $this->makeMessageValue($value);

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

        $list['string @Coração!# not contains $'] = $this->makeIncorrectItem('@Coração!#', '$');
        $list['string @Coração!# not contains @Cr'] = $this->makeIncorrectItem('@Coração!#', '@Cr');

        $arrayValue = [
            111,    // inteiro
            '222',  // inteiro string
            22.5,   // decimal
            '11.5', // decimal string
            'ção!#' // string
        ];

        $list['array not contains string 111'] = $this->makeIncorrectItem($arrayValue, '111');
        $list['array not contains integer 222'] = $this->makeIncorrectItem($arrayValue, 222);
        $list['array not contains string 22.5'] = $this->makeIncorrectItem($arrayValue, '22.5');
        $list['array not contains decimal 11.5'] = $this->makeIncorrectItem($arrayValue, 11.5);
        $list['array not contains string $'] = $this->makeIncorrectItem($arrayValue, '$');
        $list['array not contains string @Cr'] = $this->makeIncorrectItem($arrayValue, '@Cr');

        $list['object not valid'] = $this->makeIncorrectItem(new stdClass(), '');

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
