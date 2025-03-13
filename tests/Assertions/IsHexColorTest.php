<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsHexColor;
use stdClass;

class IsHexColorTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['hexcolor 1'] = ['#123456'];
        $list['hexcolor 2'] = ['#ABCDEF'];
        $list['hexcolor 3'] = ['#012345'];
        $list['hexcolor 4'] = ['#FEDCBA'];
        $list['hexcolor 5'] = ['#987654'];
        $list['hexcolor 6'] = ['#3210AB'];
        $list['hexcolor 7'] = ['#CDEF01'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(mixed $text): void
    {
        $assertion = new IsHexColor($text);

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
        $list = [];

        $list['invalid hexcolor 1']  = $this->makeIncorrectItem('#12345G');
        $list['invalid hexcolor 2']  = $this->makeIncorrectItem('#ABCDEFG');
        $list['invalid hexcolor 3']  = $this->makeIncorrectItem('#0123456');
        $list['invalid hexcolor 4']  = $this->makeIncorrectItem('#ABCDEF0');
        $list['invalid hexcolor 5']  = $this->makeIncorrectItem('#1234567');
        $list['invalid hexcolor 6']  = $this->makeIncorrectItem('#ABCDEF01');
        $list['invalid hexcolor 7']  = $this->makeIncorrectItem('#12345678');
        $list['invalid hexcolor 8']  = $this->makeIncorrectItem('#ABCDEF012');
        $list['invalid hexcolor 9']  = $this->makeIncorrectItem('#123456789');
        $list['invalid hexcolor 10'] = $this->makeIncorrectItem('#ABCDEF0123');
        $list['invalid hexcolor 11'] = $this->makeIncorrectItem('#123456789A');
        $list['invalid hexcolor 12'] = $this->makeIncorrectItem('#ABCDEF01234');
        $list['invalid hexcolor 13'] = $this->makeIncorrectItem('#123456789AB');
        $list['invalid hexcolor 14'] = $this->makeIncorrectItem('#ABCDEF012345');
        $list['invalid hexcolor 15'] = $this->makeIncorrectItem('#123456789ABC');
        $list['invalid hexcolor 16'] = $this->makeIncorrectItem('#ABCDEF0123456');
        $list['invalid hexcolor 17'] = $this->makeIncorrectItem('#123456789ABCD');
        $list['invalid hexcolor 18'] = $this->makeIncorrectItem('#ABCDEF01234567');
        $list['invalid hexcolor 19'] = $this->makeIncorrectItem('#123456789ABCDEF');
        $list['invalid hexcolor 20'] = $this->makeIncorrectItem('#ABCDEF012345678');
        $list['empty string']      = $this->makeIncorrectItem('');
        $list['one space string']  = $this->makeIncorrectItem(' ');
        $list['two spaces string'] = $this->makeIncorrectItem('  ');
        $list['array']             = $this->makeIncorrectItem(['a']);
        $list['object']            = $this->makeIncorrectItem(new stdClass());
        $list['false']             = $this->makeIncorrectItem(false);
        $list['true']              = $this->makeIncorrectItem(true);
        $list['null']              = $this->makeIncorrectItem(null);

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotHexColor(mixed $text): void
    {
        $assertion = new IsHexColor($text);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid hexadecimal color"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotHexColor(mixed $text): void
    {
        $assertion = new IsHexColor($text);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid hexadecimal color"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotHexColorWithCustomMessage(mixed $text, string $message): void
    {
        $assertion = new IsHexColor($text);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotHexColorWithCustomMessage(mixed $text, string $message): void
    {
        $assertion = new IsHexColor($text);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
