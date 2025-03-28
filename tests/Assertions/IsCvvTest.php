<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\CreditCardBrand;
use Iquety\Shield\Assertion\IsCvv;
use stdClass;

class IsCvvTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        $list = [];

        $list['amex valido']        = [CreditCardBrand::AMEX, 4442];
        $list['mastercard valido']  = [CreditCardBrand::MASTERCARD, 444];
        $list['visa valido']        = [CreditCardBrand::VISA, 444];
        $list['discover valido']    = [CreditCardBrand::DISCOVER, 444];
        $list['jcb valido']         = [CreditCardBrand::JCB, 444];
        $list['diners club valido'] = [CreditCardBrand::DINERS_CLUB, 444];

        $list['string amex valido']        = [CreditCardBrand::AMEX, '4442'];
        $list['string mastercard valido']  = [CreditCardBrand::MASTERCARD, '444'];
        $list['string visa valido']        = [CreditCardBrand::VISA, '444'];
        $list['string discover valido']    = [CreditCardBrand::DISCOVER, '444'];
        $list['string jcb valido']         = [CreditCardBrand::JCB, '444'];
        $list['string diners club valido'] = [CreditCardBrand::DINERS_CLUB, '444'];

        $list['stringable diners club'] = [CreditCardBrand::DINERS_CLUB, $this->makeStringableObject('444')];

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsCvv(CreditCardBrand $brand, mixed $number): void
    {
        $assertion = new IsCvv($number, $brand);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(CreditCardBrand $brand, mixed $value): array
    {
        $messageValue = $this->makeMessageValue($value);

        return [
            $brand,
            $value,
            "O valor $messageValue está errado" // mensagem personalizada
        ];
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @return array<string,array<int,mixed>>
     */
    public function invalidProvider(): array
    {
        $list = [];

        $list['amex invalido']        = $this->makeIncorrectItem(CreditCardBrand::AMEX, 444);
        $list['mastercard invalido']  = $this->makeIncorrectItem(CreditCardBrand::MASTERCARD, 4442);
        $list['visa invalido']        = $this->makeIncorrectItem(CreditCardBrand::VISA, 4442);
        $list['discover invalido']    = $this->makeIncorrectItem(CreditCardBrand::DISCOVER, 4442);
        $list['jcb invalido']         = $this->makeIncorrectItem(CreditCardBrand::JCB, 4442);
        $list['diners club invalido'] = $this->makeIncorrectItem(CreditCardBrand::DINERS_CLUB, 4442);

        $list['string amex invalido']        = $this->makeIncorrectItem(CreditCardBrand::AMEX, '444');
        $list['string mastercard invalido']  = $this->makeIncorrectItem(CreditCardBrand::MASTERCARD, '4442');
        $list['string visa invalido']        = $this->makeIncorrectItem(CreditCardBrand::VISA, '4442');
        $list['string discover invalido']    = $this->makeIncorrectItem(CreditCardBrand::DISCOVER, '4442');
        $list['string jcb invalido']         = $this->makeIncorrectItem(CreditCardBrand::JCB, '4442');
        $list['string diners club invalido'] = $this->makeIncorrectItem(CreditCardBrand::DINERS_CLUB, '4442');

        $list['stringable diners club']
            = $this->makeIncorrectItem(CreditCardBrand::DINERS_CLUB, $this->makeStringableObject('4442'));

        foreach (CreditCardBrand::all() as $brand) {
            $list[$brand . ' empty string']      = $this->makeIncorrectItem(CreditCardBrand::from($brand), '');
            $list[$brand . ' one space string']  = $this->makeIncorrectItem(CreditCardBrand::from($brand), ' ');
            $list[$brand . ' two spaces string'] = $this->makeIncorrectItem(CreditCardBrand::from($brand), '  ');

            $list[$brand . ' boolean'] = $this->makeIncorrectItem(CreditCardBrand::from($brand), false);
            $list[$brand . ' array']   = $this->makeIncorrectItem(CreditCardBrand::from($brand), ['a']);
            $list[$brand . ' object']  = $this->makeIncorrectItem(CreditCardBrand::from($brand), new stdClass());
            $list[$brand . ' false']   = $this->makeIncorrectItem(CreditCardBrand::from($brand), false);
            $list[$brand . ' true']    = $this->makeIncorrectItem(CreditCardBrand::from($brand), true);
            $list[$brand . ' null']    = $this->makeIncorrectItem(CreditCardBrand::from($brand), null);
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotCvv(CreditCardBrand $brand, mixed $number): void
    {
        $assertion = new IsCvv($number, $brand);

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid card verification code"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotCvv(
        CreditCardBrand $brand,
        mixed $number
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
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotCvvWithCustomMessage(
        CreditCardBrand $brand,
        mixed $number,
        string $message
    ): void {
        $assertion = new IsCvv($number, $brand);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotCvvWithCustomMessage(
        CreditCardBrand $brand,
        mixed $number,
        string $message
    ): void {
        $assertion = new IsCvv($number, $brand);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
