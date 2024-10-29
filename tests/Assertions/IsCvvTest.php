<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\CreditCardBrand;
use Iquety\Shield\Assertion\IsCvv;
use Tests\TestCase;

// @todo
class IsCvvTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        $list = [];

        $list['Amex valido'] = [CreditCardBrand::AMEX, 4442];
        $list['MasterCard valido'] = [CreditCardBrand::MASTERCARD, 444];
        $list['Visa valido'] = [CreditCardBrand::VISA, 444];
        $list['Discover valido'] = [CreditCardBrand::DISCOVER, 444];
        $list['JCB valido'] = [CreditCardBrand::JCB, 444];
        $list['Diners Club valido'] = [CreditCardBrand::DINERS_CLUB, 444];

        return $list;
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(CreditCardBrand $brand, int|string $number): void
    {
        $assertion = new IsCvv($number, $brand);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['Amex invalido'] = [CreditCardBrand::AMEX, 444];
        $list['MasterCard invalido'] = [CreditCardBrand::MASTERCARD, 4442];
        $list['Visa invalido'] = [CreditCardBrand::VISA, 4442];
        $list['Discover invalido'] = [CreditCardBrand::DISCOVER, 4442];
        $list['JCB invalido'] = [CreditCardBrand::JCB, 4442];
        $list['Diners Club invalido'] = [CreditCardBrand::DINERS_CLUB, 4442];
        
        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(CreditCardBrand $brand, int|string $number): void
    {
        $assertion = new IsCvv($number, $brand);

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid card verification code"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(
        CreditCardBrand $brand,
        int|string $number
    ): void {
        $assertion = new IsCvv($number, $brand);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid card verification code"
        );
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(
        CreditCardBrand $brand,
        int|string $number
    ): void {
        $assertion = new IsCvv($number, $brand);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $number está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(
        CreditCardBrand $brand,
        int|string $number
    ): void {
        $assertion = new IsCvv($number, $brand);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $number está errado");
    }
}
