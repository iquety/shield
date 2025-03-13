<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\CreditCardBrand;
use Iquety\Shield\Message;

class IsCreditCardBrand extends Assertion
{
    public function __construct(mixed $creditCardNumber, CreditCardBrand $brand)
    {
        // Remove todos os caracteres não-numéricos
        $this->setValue($creditCardNumber);

        $this->setAssertValue($brand);
    }

    public function isValid(): bool
    {
        $brand = $this->getAssertValue();

        return $brand === $this->resolvedBrand();
    }

    /** @SuppressWarnings(PHPMD.StaticAccess) */
    private function resolvedBrand(): CreditCardBrand
    {
        $creditCardNumber = $this->getValue();

        if (
            is_bool($creditCardNumber) === true
            || is_object($creditCardNumber) === true
            || is_array($creditCardNumber) === true
        ) {
            return CreditCardBrand::UNKNOWN;
        }

        $creditCardNumber = (string)preg_replace('/\D/', '', (string)$creditCardNumber);

        $brandList = CreditCardBrand::all();

        foreach ($brandList as $brandName) {
            $pattern = CreditCardBrand::from($brandName)->pattern();

            if (
                preg_match($pattern, $creditCardNumber) === 1
                && strlen($creditCardNumber) === $this->getSize($brandName)
            ) {
                return CreditCardBrand::from($brandName);
            }
        }

        return CreditCardBrand::UNKNOWN;
    }

    private function getSize(string $brandName): int
    {
        return match ($brandName) {
            CreditCardBrand::VISA->value => 16,
            CreditCardBrand::MASTERCARD->value => 16,
            CreditCardBrand::DISCOVER->value => 16,
            CreditCardBrand::JCB->value => 16,
            CreditCardBrand::AMEX->value => 15,
            CreditCardBrand::DINERS_CLUB->value => 14,
            default => 0
        };
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid credit card brand");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid credit card brand",
        );
    }
}
