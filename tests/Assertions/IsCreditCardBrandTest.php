<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsCreditCardBrand;
use Iquety\Shield\CreditCardBrand;
use Tests\TestCase;

class IsCreditCardBrandTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
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
     * @dataProvider correctValueProvider
     */
    public function assertedCase(int|string $number, CreditCardBrand $brand): void
    {
        $assertion = new IsCreditCardBrand($number, $brand);

        $this->assertTrue($assertion->isValid());
    }

    /**
     * @return array<string,array<int,mixed>>
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function incorrectValueProvider(): array
    {
        $list = [];

        foreach (CreditCardBrand::all() as $brand) {
            $list["Random number $brand"] = ['1234567890123456', CreditCardBrand::from($brand)];

            $list["Too short $brand 1 digit"] = ['4', CreditCardBrand::from($brand)];
            $list["Too short $brand 2 digits"] = ['41', CreditCardBrand::from($brand)];
            $list["Too short $brand 3 digits"] = ['411', CreditCardBrand::from($brand)];
            $list["Too short $brand 4 digits"] = ['4111', CreditCardBrand::from($brand)];
            $list["Too short $brand 5 digits"] = ['41111', CreditCardBrand::from($brand)];
            $list["Too short $brand 6 digits"] = ['411111', CreditCardBrand::from($brand)];
            $list["Too short $brand 7 digits"] = ['4111111', CreditCardBrand::from($brand)];
            $list["Too short $brand 8 digits"] = ['41111111', CreditCardBrand::from($brand)];
            $list["Too short $brand 9 digits"] = ['411111111', CreditCardBrand::from($brand)];
            $list["Too short $brand 10 digits"] = ['4111111111', CreditCardBrand::from($brand)];
            $list["Too short $brand 11 digits"] = ['41111111111', CreditCardBrand::from($brand)];
            $list["Too short $brand 12 digits"] = ['411111111111', CreditCardBrand::from($brand)];
            $list["Too short $brand 13 digits"] = ['4111111111111', CreditCardBrand::from($brand)];

            $list["Too long $brand 17"] = ['55000000000000000', CreditCardBrand::from($brand)];
            $list["Too long $brand 18"] = ['550000000000000000', CreditCardBrand::from($brand)];
            $list["Too long $brand 19"] = ['5500000000000000000', CreditCardBrand::from($brand)];
            $list["Too long $brand 20"] = ['55000000000000000000', CreditCardBrand::from($brand)];

            $list["Non-numeric $brand"] = ['abcdefg', CreditCardBrand::from($brand)];
            $list["Empty string $brand"] = ['', CreditCardBrand::from($brand)];
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(int|string $number, CreditCardBrand $brand): void
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
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(int|string $number, CreditCardBrand $brand): void
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
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(int|string $number, CreditCardBrand $brand): void
    {
        $assertion = new IsCreditCardBrand($number, $brand);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $number está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(int|string $number, CreditCardBrand $brand): void
    {
        $assertion = new IsCreditCardBrand($number, $brand);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $number está errado");
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function fromNumber(int|string $number, CreditCardBrand $brand): void
    {
        $this->assertEquals(
            $brand,
            CreditCardBrand::fromNumber($number)
        );
    }
}
