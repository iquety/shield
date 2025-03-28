<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsAlpha;
use stdClass;

class IsAlphaTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['text 1']         = ['TEXTO'];
        $list['text 2']         = ['abc'];
        $list['text 3']         = ['xyz'];
        $list['text 4']         = ['TextoABC'];
        $list['text 5']         = ['XYZTexto'];
        $list['text 6']         = ['TextoXYZ'];
        $list['text 7']         = ['TextoABC'];
        $list['text 8']         = ['abcxyz'];
        $list['text 9']         = ['AbCxYz'];
        $list['text 10']        = ['texto'];
        $list['boolean string'] = ['false'];
        $list['stringable']     = [$this->makeStringableObject('false')];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueIsAlpha(mixed $value): void
    {
        $assertion = new IsAlpha($value);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value): array
    {
        $messageValue = $this->makeMessageValue($value);

        return [
            $value,
            "O valor $messageValue está errado" // mensagem personalizada
        ];
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        return [
            'iso 8601 dirty'                 => $this->makeIncorrectItem('00002024-12-31xxx'),
            'european format dirty'          => $this->makeIncorrectItem('31/12//2024'),
            'us format dirty'                => $this->makeIncorrectItem('xxx12/31/2024'),
            'alternative format dirty'       => $this->makeIncorrectItem('rr2x024.12.31'),
            'abbreviated month name dirty'   => $this->makeIncorrectItem('xxx31-Dec-2024'),
            'full month name dirty'          => $this->makeIncorrectItem('xxxDecember 31, 2024'),
            'iso 8601 invalid month'         => $this->makeIncorrectItem('2024-13-31'),
            'iso 8601 invalid day'           => $this->makeIncorrectItem('2024-12-32'),
            'european format month'          => $this->makeIncorrectItem('31/13/2024'),
            'european format day'            => $this->makeIncorrectItem('32/12/2024'),
            'us format month'                => $this->makeIncorrectItem('13/31/2024'),
            'us format day'                  => $this->makeIncorrectItem('12/32/2024'),
            'alternative format month'       => $this->makeIncorrectItem('2024.13.31'),
            'alternative format day'         => $this->makeIncorrectItem('2024.12.32'),
            'abbreviated month name month'   => $this->makeIncorrectItem('31-Err-2024'),
            'abbreviated month name day'     => $this->makeIncorrectItem('32-Dec-2024'),
            'full month name month'          => $this->makeIncorrectItem('Invalid 31, 2024'),
            'full month name day'            => $this->makeIncorrectItem('December 32, 2024'),
            'special characters'             => $this->makeIncorrectItem('@#$%^&*()'),
            'numbers and special characters' => $this->makeIncorrectItem('123@#$%'),
            'empty string'                   => $this->makeIncorrectItem(''),
            'one space string'               => $this->makeIncorrectItem(' '),
            'two spaces string'              => $this->makeIncorrectItem('  '),
            'integer'                        => $this->makeIncorrectItem(123456),
            'decimal'                        => $this->makeIncorrectItem(123.456),
            'array'                          => $this->makeIncorrectItem(['a']),
            'object'                         => $this->makeIncorrectItem(new stdClass()),
            'false'                          => $this->makeIncorrectItem(false),
            'true'                           => $this->makeIncorrectItem(true),
            'null'                           => $this->makeIncorrectItem(null),
            'stringable'                     => $this->makeIncorrectItem($this->makeStringableObject('123@#$%')),
        ];
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotAlpha(mixed $value): void
    {
        $assertion = new IsAlpha($value);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must contain only letters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotAlpha(mixed $value): void
    {
        $assertion = new IsAlpha($value);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must contain only letters"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotAlphaAndCustomMessage(mixed $value, string $message): void
    {
        $assertion = new IsAlpha($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotAlphaWithCustomMessage(mixed $value, string $message): void
    {
        $assertion = new IsAlpha($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
