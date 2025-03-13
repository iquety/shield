<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\EndsWith;
use stdClass;

class EndsWithTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['string ends with !#'] = ['@Coração!#', '!#'];

        $arrayValue = [
            null,
            111,    // inteiro
            '222',  // inteiro string
            22.5,   // decimal
            '11.5', // decimal string
            'ção!#' // string
        ];

        $list['array ends with string'] = [$arrayValue, 'ção!#'];

        array_pop($arrayValue);
        $list['array ends with decimal string'] = [$arrayValue, '11.5'];

        array_pop($arrayValue);
        $list['array ends with decimal'] = [$arrayValue, 22.5];

        array_pop($arrayValue);
        $list['array ends with integer string'] = [$arrayValue, '222'];

        array_pop($arrayValue);
        $list['array ends with integer'] = [$arrayValue, 111];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueEndsWithPartial(mixed $value, mixed $partial): void
    {
        $assertion = new EndsWith($value, $partial);

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
    public function invalidProvider(): array
    {
        $list = [];

        $list['string not end with $']   = $this->makeIncorrectItem('@Coração!#', '$');
        $list['string not end with @Cr'] = $this->makeIncorrectItem('@Coração!#', '@Cr');
        $list['object not valid']        = $this->makeIncorrectItem(new stdClass(), '');
        $list['null not valid']          = $this->makeIncorrectItem(null, '');
        $list['true not valid']          = $this->makeIncorrectItem(true, '');
        $list['false not valid']         = $this->makeIncorrectItem(false, '');

        $arrayValue = [
            null,
            111,    // inteiro
            '222',  // inteiro string
            22.5,   // decimal
            '11.5', // decimal string
            'ção!#' // string
        ];

        $list['array not end with string ção!'] = $this->makeIncorrectItem($arrayValue, 'ção');

        array_pop($arrayValue);
        $list['array not end with decimal 11.5'] = $this->makeIncorrectItem($arrayValue, 11.5);

        array_pop($arrayValue);
        $list['array not end with decimal string 22.5'] = $this->makeIncorrectItem($arrayValue, '22.5');

        array_pop($arrayValue);
        $list['array not end with integer 222'] = $this->makeIncorrectItem($arrayValue, 222);

        array_pop($arrayValue);
        $list['array not end with integer string 111'] = $this->makeIncorrectItem($arrayValue, '111');

        array_pop($arrayValue);
        $list['array not end with null string'] = $this->makeIncorrectItem($arrayValue, 'null');

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueNotEndsWithPartial(mixed $value, float|int|string $needle): void
    {
        $assertion = new EndsWith($value, $needle);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), "Value must end with '$needle'");
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueNotEndsWithPartial(mixed $value, float|int|string $needle): void
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
     * @dataProvider invalidProvider
     */
    public function namedValueNotEndsWithPartialWithCustomMessage(
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
     * @dataProvider invalidProvider
     */
    public function valueNotEndsWithPartialAndCustomMessage(
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
