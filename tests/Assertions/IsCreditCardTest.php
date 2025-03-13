<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsCreditCard;
use stdClass;

class IsCreditCardTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['Visa'] = ['4111111111111111'];
        $list['MasterCard'] = ['5500000000000004'];
        $list['American Express'] = ['340000000000009'];
        $list['Diners Club'] = ['30000000000004'];
        $list['Discover'] = ['6011000000000004'];
        // $list['enRoute'] = ['201400000000009'];
        $list['JCB'] = ['3088000000000009'];

        $list['Visa numeric'] = [4111111111111111];
        $list['MasterCard numeric'] = [5500000000000004];
        $list['American Express numeric'] = [340000000000009];
        $list['Diners Club numeric'] = [30000000000004];
        $list['Discover numeric'] = [6011000000000004];
        // $list['enRoute numeric'] = [201400000000009];
        $list['JCB numeric'] = [3088000000000009];

        $list['Visa with signals'] = ['4111-1111-1111-1111'];
        $list['MasterCard with signals'] = ['5500-0000-0000-0004'];
        $list['American Express with signals'] = ['3400-000000-00009'];
        $list['Diners Club with signals'] = ['3000-000000-0004'];
        $list['Discover with signals'] = ['6011-0000-0000-0004'];
        // $list['enRoute with signals'] = ['2014-0000-0000-009'];
        $list['JCB with signals'] = ['3088-0000-0000-0009'];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function valueIsCreditCard(mixed $number): void
    {
        $assertion = new IsCreditCard($number);

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

        $list['random number']     = $this->makeIncorrectItem('1234567890123456');
        $list['too short']         = $this->makeIncorrectItem('4111111111111');
        $list['too long']          = $this->makeIncorrectItem('55000000000000000000');
        $list['non-numeric']       = $this->makeIncorrectItem('abcdefg');
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
    public function valueIsNotCreditCard(mixed $number): void
    {
        $assertion = new IsCreditCard($number);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid credit card number"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotCreditCard(mixed $number): void
    {
        $assertion = new IsCreditCard($number);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid credit card number"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function namedValueIsNotCreditCardAndCustomMessage(mixed $number, string $message): void
    {
        $assertion = new IsCreditCard($number);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function valueIsNotCreditCardAndCustomMessage(mixed $number, string $message): void
    {
        $assertion = new IsCreditCard($number);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
