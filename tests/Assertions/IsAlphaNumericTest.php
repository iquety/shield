<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsAlphaNumeric;
use stdClass;

class IsAlphaNumericTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['Upper case string']           = ['CORAÇÃO'];
        $list['Lower case string']           = ['coração'];
        $list['Upper case string + integer'] = ['CORAÇÃO123'];
        $list['Lower case string + integer'] = ['coração123'];
        $list['string integer']              = ['123'];
        $list['string decimal']              = ['12.3'];
        $list['string boolean']              = ['false'];
        $list['integer']                     = [123];
        $list['decimal']                     = [12.3];
        $list['stringable']                  = [$this->makeStringableObject('CORAÇÃO')];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsAlphaNumeric(mixed $alphaNumeric): void
    {
        $assertion = new IsAlphaNumeric($alphaNumeric);

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
            'array'                          => $this->makeIncorrectItem(['a']),
            'object'                         => $this->makeIncorrectItem(new stdClass()),
            'false'                          => $this->makeIncorrectItem(false),
            'true'                           => $this->makeIncorrectItem(true),
            'null'                           => $this->makeIncorrectItem(null)
        ];
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotAlphaNumeric(mixed $value): void
    {
        $assertion = new IsAlphaNumeric($value);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must contain only letters and numbers"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotAlphaNumeric(mixed $value): void
    {
        $assertion = new IsAlphaNumeric($value);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must contain only letters and numbers"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotAlphaNumericAndCustomMessage(mixed $value, string $message): void
    {
        $assertion = new IsAlphaNumeric($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotAlphaNumericWithCustomMessage(mixed $value, string $message): void
    {
        $assertion = new IsAlphaNumeric($value);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
