<?php

declare(strict_types=1);

namespace Iquety\Shield;

use Stringable;
use ValueError;

enum CreditCardBrand: string
{
    case MASTERCARD = 'mastercard';
    case VISA = 'visa';
    case DISCOVER = 'discover';
    case JCB = 'jcb';
    case AMEX = 'amex';
    case DINERS_CLUB = 'diners_club';
    case UNKNOWN = 'unknown';

    /** @return array<int,string> */
    public static function all(): array
    {
        return [
            'mastercard',
            'visa',
            'discover',
            'jcb',
            'amex',
            'diners_club'
        ];
    }

    public function pattern(): string
    {
        return match ($this) {
            // 16 dígitos: 5555 5555 5555 4444
            self::MASTERCARD => "/^"
                . "5[1-5][0-9]{14}$|^2(?:2(?:2[1-9]|[3-9][0-9])|"
                . "[3-6][0-9][0-9]|7(?:[01][0-9]|20))[0-9]{12}"
                . "$/",
            // 16 dígitos 4242 4242 4242 4242
            self::VISA => "/^4[0-9]{12}(?:[0-9]{3})?$/",
            // 16 dígitos: 6011 1111 1111 1117
            self::DISCOVER => "/^"
                . "65[4-9][0-9]{13}|64[4-9][0-9]{13}|6011[0-9]{12}|"
                . "(622(?:12[6-9]|1[3-9][0-9]|[2-8][0-9][0-9]|9[01][0-9]|92[0-5])[0-9]{10})"
                . "$/",
            // 16 dígitos: 3530 1113 3330 0000
            self::JCB => "/^(3(?:088|096|112|158|337|5(?:2[89]|[3-8][0-9]))\d{12})$/",
            // 15 dígitos: 3782 822463 10005
            self::AMEX => "/^3[47][0-9]{13}$/",
            // 14 dígitos: 3056 930902 5904
            self::DINERS_CLUB => "/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/",
            default => ""
        };
    }

    public function size(): int
    {
        return match ($this) {
            CreditCardBrand::VISA => 16,
            CreditCardBrand::MASTERCARD => 16,
            CreditCardBrand::DISCOVER => 16,
            CreditCardBrand::JCB => 16,
            CreditCardBrand::AMEX => 15,
            CreditCardBrand::DINERS_CLUB => 14,
            default => 0
        };
    }

    public static function fromNumber(int|string|Stringable $creditCardNumber): self
    {
        $originalNumber = (string)$creditCardNumber;

        $creditCardNumber = (string)preg_replace('/\D/', '', (string)$creditCardNumber);

        $brandList = self::all();

        foreach ($brandList as $brandName) {
            $brand = self::from($brandName);

            if (
                preg_match($brand->pattern(), $creditCardNumber) === 1
                && strlen($creditCardNumber) === $brand->size()
            ) {
                return $brand;
            }
        }

        throw new ValueError(sprintf(
            "Credit card '%s' is not a valid backing value for enum '%s'",
            $originalNumber,
            self::class
        ));
    }
}
