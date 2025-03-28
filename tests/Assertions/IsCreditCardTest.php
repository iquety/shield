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

        $list['visa'] = ['4111111111111111'];
        $list['mastercard'] = ['5500000000000004'];
        $list['american express'] = ['340000000000009'];
        $list['diners club'] = ['30000000000004'];
        $list['discover'] = ['6011000000000004'];
        // $list['enroute'] = ['201400000000009'];
        $list['jcb'] = ['3088000000000009'];

        $list['visa numeric'] = [4111111111111111];
        $list['mastercard numeric'] = [5500000000000004];
        $list['american express numeric'] = [340000000000009];
        $list['diners club numeric'] = [30000000000004];
        $list['discover numeric'] = [6011000000000004];
        // $list['enroute numeric'] = [201400000000009];
        $list['jcb numeric'] = [3088000000000009];

        $list['visa with signals'] = ['4111-1111-1111-1111'];
        $list['mastercard with signals'] = ['5500-0000-0000-0004'];
        $list['american express with signals'] = ['3400-000000-00009'];
        $list['diners club with signals'] = ['3000-000000-0004'];
        $list['discover with signals'] = ['6011-0000-0000-0004'];
        // $list['enroute with signals'] = ['2014-0000-0000-009'];
        $list['jcb with signals'] = ['3088-0000-0000-0009'];

        $list['stringable with signals'] = [$this->makeStringableObject('3088-0000-0000-0009')];

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

        $list['random number']          = $this->makeIncorrectItem('1234567890123456');
        $list['too short']              = $this->makeIncorrectItem('4111111111111');
        $list['too long']               = $this->makeIncorrectItem('55000000000000000000');
        $list['non-numeric']            = $this->makeIncorrectItem('abcdefg');
        $list['empty string']           = $this->makeIncorrectItem('');
        $list['one space string']       = $this->makeIncorrectItem(' ');
        $list['two spaces string']      = $this->makeIncorrectItem('  ');
        $list['array']                  = $this->makeIncorrectItem(['a']);
        $list['object']                 = $this->makeIncorrectItem(new stdClass());
        $list['false']                  = $this->makeIncorrectItem(false);
        $list['true']                   = $this->makeIncorrectItem(true);
        $list['null']                   = $this->makeIncorrectItem(null);
        $list["stringable non-numeric"] = $this->makeIncorrectItem($this->makeStringableObject('abcdefg'));

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
