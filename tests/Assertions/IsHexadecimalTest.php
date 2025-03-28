<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsHexadecimal;
use stdClass;

class IsHexadecimalTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['valid hexadecimal 1'] = ['1234567890abcdef'];
        $list['valid hexadecimal 2'] = ['ABCDEF0123456789'];
        $list['valid hexadecimal 3'] = ['0123456789abcdefABCDEF'];
        $list['valid hexadecimal 4'] = ['0123456789ABCDEFabcdef'];
        $list['valid hexadecimal 5'] = ['1234567890ABCDEFabcdef0'];
        $list['valid hexadecimal 6'] = ['0123456789abcdefABCDEF0'];
        $list['valid hexadecimal 7'] = ['1234567890ABCDEFabcdef0123456789abcdef'];
        $list['valid hexadecimal 8'] = ['0123456789abcdefABCDEF0123456789abcdef'];
        $list['valid hexadecimal 9'] = ['1234567890ABCDEFabcdef0123456789ABCDEF'];
        $list['valid hexadecimal 10'] = ['0123456789abcdefABCDEF0123456789ABCDEF'];

        $list['valid stringable hexadecimal'] = [$this->makeStringableObject('1234567890abcdef')];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsHexadecimal(mixed $value): void
    {
        $assertion = new IsHexadecimal($value);

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
    public function invalidProvider(): array
    {
        $list = [];

        $list['invalid hexadecimal 1']  = $this->makeIncorrectItem('1234567890g');
        $list['invalid hexadecimal 2']  = $this->makeIncorrectItem('ABCDEF012345678G');
        $list['invalid hexadecimal 3']  = $this->makeIncorrectItem('0123456789abcdefG');
        $list['invalid hexadecimal 4']  = $this->makeIncorrectItem('0123456789ABCDEFg');
        $list['invalid hexadecimal 5']  = $this->makeIncorrectItem('1234567890ABCDEFabcdefg');
        $list['invalid hexadecimal 6']  = $this->makeIncorrectItem('0123456789abcdefABCDEFg');
        $list['invalid hexadecimal 7']  = $this->makeIncorrectItem('1234567890ABCDEFabcdefg123456789abcdef');
        $list['invalid hexadecimal 8']  = $this->makeIncorrectItem('0123456789abcdefABCDEFg123456789abcdef');
        $list['invalid hexadecimal 9']  = $this->makeIncorrectItem('1234567890ABCDEFabcdefg123456789ABCDEF');
        $list['invalid hexadecimal 10'] = $this->makeIncorrectItem('0123456789abcdefABCDEFg123456789ABCDEF');
        $list['empty string']           = $this->makeIncorrectItem('');
        $list['one space string']       = $this->makeIncorrectItem(' ');
        $list['two spaces string']      = $this->makeIncorrectItem('  ');
        $list['array']                  = $this->makeIncorrectItem(['a']);
        $list['object']                 = $this->makeIncorrectItem(new stdClass());
        $list['false']                  = $this->makeIncorrectItem(false);
        $list['true']                   = $this->makeIncorrectItem(true);
        $list['null']                   = $this->makeIncorrectItem(null);
        $list['invalid stringable hexadecimal']
            = $this->makeIncorrectItem($this->makeStringableObject('1234567890g'));

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotHexadecimal(mixed $value): void
    {
        $assertion = new IsHexadecimal($value);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid hexadecimal number"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotHexadecimal(mixed $value): void
    {
        $assertion = new IsHexadecimal($value);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid hexadecimal number"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotHexadecimalWithCustomMessage(
        mixed $value,
        string $message
    ): void {
        $assertion = new IsHexadecimal($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotHexadecimalWithCustomMessage(
        mixed $value,
        string $message
    ): void {
        $assertion = new IsHexadecimal($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
