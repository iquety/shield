<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\StartsWith;
use Tests\TestCase;

class StartsWithTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['string starts with @'] = ['@Coração!#', '@Co'];

        $arrayValue = [
            111,    // inteiro
            '222',  // inteiro string
            22.5,   // decimal
            '11.5', // decimal string
            'ção!#' // string
        ];
        
        $list['array starts with integer 111'] = [$arrayValue, 111];

        array_shift($arrayValue);
        $list['array starts with integer string 222'] = [$arrayValue, '222'];

        array_shift($arrayValue);
        $list['array starts with decimal 22.5'] = [$arrayValue, 22.5];

        array_shift($arrayValue);
        $list['array starts with decimal string 11.5'] = [$arrayValue, '11.5'];

        array_shift($arrayValue);
        $list['array starts with string ção!#'] = [$arrayValue, 'ção!#'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueStartsWithPartial(mixed $value, mixed $partial): void
    {
        $assertion = new StartsWith($value, $partial);

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

        $list['string not start with $'] = $this->makeIncorrectItem('@Coração!#', '$');
        $list['string not start with @Cr'] = $this->makeIncorrectItem('@Coração!#', '@Cr');

        $arrayValue = [
            null,
            111,    // inteiro
            '222',  // inteiro string
            22.5,   // decimal
            '11.5', // decimal string
            'ção!#' // string
        ];

        $list['array not start with null string'] = $this->makeIncorrectItem($arrayValue, 'null');

        array_pop($arrayValue);
        $list['array not start with integer string 111'] = $this->makeIncorrectItem($arrayValue, '111');

        array_pop($arrayValue);
        $list['array not start with integer 222'] = $this->makeIncorrectItem($arrayValue, 222);

        array_pop($arrayValue);
        $list['array not start with decimal string 22.5'] = $this->makeIncorrectItem($arrayValue, '22.5');

        array_pop($arrayValue);
        $list['array not start with decimal 11.5'] = $this->makeIncorrectItem($arrayValue, 11.5);

        array_pop($arrayValue);
        $list['array not start with string ção!'] = $this->makeIncorrectItem($arrayValue, 'ção!');

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueNotStartsWithPartial(mixed $value, float|int|string $needle): void
    {
        $assertion = new StartsWith($value, $needle);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), "Value must start with '$needle'");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueNotStartsWithPartial(mixed $value, float|int|string $needle): void
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
    public function namedValueNotStartsWithPartialAndCustomMessage(
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
    public function valueNotStartsWithPartialAndCustomMessage(
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
