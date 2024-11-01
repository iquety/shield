<?php

declare(strict_types=1);

namespace Tests\Assertions;

use InvalidArgumentException;
use Iquety\Shield\CreditCard;
use Iquety\Shield\CreditCardBrand;
use Tests\TestCase;
use ValueError;

class CreditCardTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctNumberProvider(): array
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
     * @dataProvider correctNumberProvider
     */
    public function constructor(int|string $number): void
    {
        $instance = new CreditCard($number);

        $this->assertInstanceOf(CreditCard::class, $instance);

        $this->assertEquals(
            (int)preg_replace('/\D/', '', (string)$number),
            $instance->getNumber()
        );
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectNumberProvider(): array
    {
        $list = [];

        $list["Random number string"] = ['1234567890123456'];
        $list["Too short 1 digit string"] = ['4'];
        $list["Too short 2 digits string"] = ['41'];
        $list["Too short 3 digits string"] = ['411'];
        $list["Too short 4 digits string"] = ['4111'];
        $list["Too short 5 digits string"] = ['41111'];
        $list["Too short 6 digits string"] = ['411111'];
        $list["Too short 7 digits string"] = ['4111111'];
        $list["Too short 8 digits string"] = ['41111111'];
        $list["Too short 9 digits string"] = ['411111111'];
        $list["Too short 10 digits string"] = ['4111111111'];
        $list["Too short 11 digits string"] = ['41111111111'];
        $list["Too short 12 digits string"] = ['411111111111'];
        $list["Too short 13 digits string"] = ['4111111111111'];
        $list["Too long 17 string"] = ['55000000000000000'];
        $list["Too long 18 string"] = ['550000000000000000'];
        $list["Too long 19 string"] = ['5500000000000000000'];
        $list["Non-numeric string"] = ['abcdefg'];
        $list["Empty string string"] = [''];

        $list["Random number numeric"] = [1234567890123456];
        $list["Too short 1 digit numeric"] = [4];
        $list["Too short 2 digits numeric"] = [41];
        $list["Too short 3 digits numeric"] = [411];
        $list["Too short 4 digits numeric"] = [4111];
        $list["Too short 5 digits numeric"] = [41111];
        $list["Too short 6 digits numeric"] = [411111];
        $list["Too short 7 digits numeric"] = [4111111];
        $list["Too short 8 digits numeric"] = [41111111];
        $list["Too short 9 digits numeric"] = [411111111];
        $list["Too short 10 digits numeric"] = [4111111111];
        $list["Too short 11 digits numeric"] = [41111111111];
        $list["Too short 12 digits numeric"] = [411111111111];
        $list["Too short 13 digits numeric"] = [4111111111111];
        $list["Too long 17 numeric"] = [55000000000000000];
        $list["Too long 18 numeric"] = [550000000000000000];
        $list["Too long 19 numeric"] = [5500000000000000000];

        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectNumberProvider
     */
    public function constructorFail(int|string $number): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Credit card number is invalid");

        new CreditCard($number);
    }

    /**
     * @test
     * @dataProvider correctNumberProvider
     */
    public function getNumber(int|string $number): void
    {
        $instance = new CreditCard($number);

        $this->assertIsInt($instance->getNumber());
    }

    /**
     * @test
     * @dataProvider correctNumberProvider
     */
    public function getBrand(int|string $number, CreditCardBrand $brand): void
    {
        $instance = new CreditCard($number);

        $this->assertSame($brand, $instance->getBrand());
    }
}
