<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsCreditCardBrand;
use Iquety\Shield\CreditCardBrand;
use stdClass;

class IsCreditCardBrandTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['Visa'] = ['4111111111111111', CreditCardBrand::VISA];
        $list['MasterCard'] = ['5500000000000004', CreditCardBrand::MASTERCARD];
        $list['American Express'] = ['340000000000009', CreditCardBrand::AMEX];
        $list['Diners Club'] = ['30000000000004', CreditCardBrand::DINERS_CLUB];
        $list['Discover'] = ['6011000000000004', CreditCardBrand::DISCOVER];
        $list['JCB'] = ['3088000000000009', CreditCardBrand::JCB];

        $list['Visa numeric'] = [4111111111111111, CreditCardBrand::VISA];
        $list['MasterCard numeric'] = [5500000000000004, CreditCardBrand::MASTERCARD];
        $list['American Express numeric'] = [340000000000009, CreditCardBrand::AMEX];
        $list['Diners Club numeric'] = [30000000000004, CreditCardBrand::DINERS_CLUB];
        $list['Discover numeric'] = [6011000000000004, CreditCardBrand::DISCOVER];
        $list['JCB numeric'] = [3088000000000009, CreditCardBrand::JCB];

        $list['Visa with signals'] = ['4111-1111-1111-1111', CreditCardBrand::VISA];
        $list['MasterCard with signals'] = ['5500-0000-0000-0004', CreditCardBrand::MASTERCARD];
        $list['American Express with signals'] = ['3400-000000-00009', CreditCardBrand::AMEX];
        $list['Diners Club with signals'] = ['3000-000000-0004', CreditCardBrand::DINERS_CLUB];
        $list['Discover with signals'] = ['6011-0000-0000-0004', CreditCardBrand::DISCOVER];
        $list['JCB with signals'] = ['3088-0000-0000-0009', CreditCardBrand::JCB];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsCreditCardBrand(mixed $number, CreditCardBrand $brand): void
    {
        $assertion = new IsCreditCardBrand($number, $brand);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value, CreditCardBrand $creditCardBrand): array
    {
        $messageValue = $this->makeMessageValue($value);

        return [
            $value,
            $creditCardBrand,
            "O valor $messageValue está errado" // mensagem personalizada
        ];
    }

    /**
     * @return array<string,array<int,mixed>>
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function invalidProvider(): array
    {
        $list = [];

        foreach (CreditCardBrand::all() as $brand) {
            $list["Random number $brand"] = $this->makeIncorrectItem('1234567890123456', CreditCardBrand::from($brand));

            $list["Too short $brand 1 digit"]   = $this->makeIncorrectItem('4', CreditCardBrand::from($brand));
            $list["Too short $brand 2 digits"]  = $this->makeIncorrectItem('41', CreditCardBrand::from($brand));
            $list["Too short $brand 3 digits"]  = $this->makeIncorrectItem('411', CreditCardBrand::from($brand));
            $list["Too short $brand 4 digits"]  = $this->makeIncorrectItem('4111', CreditCardBrand::from($brand));
            $list["Too short $brand 5 digits"]  = $this->makeIncorrectItem('41111', CreditCardBrand::from($brand));
            $list["Too short $brand 6 digits"]  = $this->makeIncorrectItem('411111', CreditCardBrand::from($brand));
            $list["Too short $brand 7 digits"]  = $this->makeIncorrectItem('4111111', CreditCardBrand::from($brand));
            $list["Too short $brand 8 digits"]  = $this->makeIncorrectItem('41111111', CreditCardBrand::from($brand));
            $list["Too short $brand 9 digits"]  = $this->makeIncorrectItem('411111111', CreditCardBrand::from($brand));
            $list["Too short $brand 10 digits"] = $this->makeIncorrectItem('4111111111', CreditCardBrand::from($brand));
            $list["Too short $brand 11 digits"] = $this->makeIncorrectItem('41111111111', CreditCardBrand::from($brand));
            $list["Too short $brand 12 digits"] = $this->makeIncorrectItem('411111111111', CreditCardBrand::from($brand));
            $list["Too short $brand 13 digits"] = $this->makeIncorrectItem('4111111111111', CreditCardBrand::from($brand));

            $list["Too long $brand 17"] = $this->makeIncorrectItem('55000000000000000', CreditCardBrand::from($brand));
            $list["Too long $brand 18"] = $this->makeIncorrectItem('550000000000000000', CreditCardBrand::from($brand));
            $list["Too long $brand 19"] = $this->makeIncorrectItem('5500000000000000000', CreditCardBrand::from($brand));
            $list["Too long $brand 20"] = $this->makeIncorrectItem('55000000000000000000', CreditCardBrand::from($brand));

            $list["Non-numeric $brand"]  = $this->makeIncorrectItem('abcdefg', CreditCardBrand::from($brand));
            $list["Empty string $brand"] = $this->makeIncorrectItem('', CreditCardBrand::from($brand));

            $list['empty string']      = $this->makeIncorrectItem('', CreditCardBrand::from($brand));
            $list['one space string']  = $this->makeIncorrectItem(' ', CreditCardBrand::from($brand));
            $list['two spaces string'] = $this->makeIncorrectItem('  ', CreditCardBrand::from($brand));
            $list['array']             = $this->makeIncorrectItem(['a'], CreditCardBrand::from($brand));
            $list['object']            = $this->makeIncorrectItem(new stdClass(), CreditCardBrand::from($brand));
            $list['false']             = $this->makeIncorrectItem(false, CreditCardBrand::from($brand));
            $list['true']              = $this->makeIncorrectItem(true, CreditCardBrand::from($brand));
            $list['null']              = $this->makeIncorrectItem(null, CreditCardBrand::from($brand));
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotCreditCardBrand(mixed $number, CreditCardBrand $brand): void
    {
        $assertion = new IsCreditCardBrand($number, $brand);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid credit card brand"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotCreditCardBrand(mixed $number, CreditCardBrand $brand): void
    {
        $assertion = new IsCreditCardBrand($number, $brand);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid credit card brand"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotCreditCardBrandWithCustomMessage(
        mixed $number,
        CreditCardBrand $brand,
        string $message
    ): void {
        $assertion = new IsCreditCardBrand($number, $brand);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotCreditCardBrandWithCustomMessage(
        mixed $number,
        CreditCardBrand $brand,
        string $message
    ): void {
        $assertion = new IsCreditCardBrand($number, $brand);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider validProvider
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function fromNumber(mixed $number, CreditCardBrand $brand): void
    {
        $this->assertEquals(
            $brand,
            CreditCardBrand::fromNumber($number)
        );
    }
}
